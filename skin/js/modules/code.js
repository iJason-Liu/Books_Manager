/**
 * code 
 * Code 预览组件
 */
 
layui.define(['lay', 'util', 'element', 'form'], function(exports){
  "use strict";
  
  var $ = layui.$;
  var util = layui.util;
  var element = layui.element;
  var form = layui.form;

  // 常量
  var CONST = {
    ELEM_VIEW: 'layui-code-view',
    ELEM_TITLE: 'layui-code-title',
    ELEM_FULL: 'layui-code-full',
    ELEM_PREVIEW: 'layui-code-preview',
    ELEM_ITEM: 'layui-code-item',
    ELEM_SHOW: 'layui-show'
  };

  // 默认参数项
  var config = {
    elem: '.layui-code', // 元素选择器
    title: '&lt;/&gt;', // 标题
    about: '', // 右上角信息
    ln: true, // 是否显示行号
    header: false, // 是否显示头部区域

    text: {
      code: util.escape('</>'),
      preview: 'Preview'
    }
  };

  var trim = function(str){
    return $.trim(str).replace(/^\n|\n$/, '');
  };
  
  // export api
  exports('code', function(options){
    var opts = options = $.extend(true, {}, config, options);

    // 目标元素是否存在
    options.elem = $(options.elem);
    if(!options.elem[0]) return;

    // 从内至外渲染
    layui.each(options.elem.get().reverse(), function(index, item){
      var othis = $(item);
      var html = trim(othis.html());

      // 合并属性上的参数，并兼容旧版本属性写法 lay-*
      var options = $.extend(true, {}, opts, lay.options(item), function(obj){
        var attrs = ['title', 'height', 'encode', 'skin', 'about'];
        layui.each(attrs, function(i, attr){
          var value = othis.attr('lay-'+ attr);
          if(typeof value === 'string'){
            obj[attr] = value;
          }  
        })
        return obj;
      }({}));

      // 获得代码
      var codes = function(){
        var arr = [];
        var textarea = othis.children('textarea');
        
        // 若内容放置在 textarea 中
        textarea.each(function(){
          arr.push(trim(this.value));
        });

        if(textarea[0]){
          html = util.escape(arr.join(''));
        }
        
        // 内容直接放置在元素外层
        if(arr.length === 0){
          arr.push(trim(othis.html()));
        }
        
        return arr;
      }();

      // 是否开启预览
      if(options.preview){
        var FILTER_VALUE = 'LAY-CODE-DF-'+ index;
        var layout = options.layout || ['code', 'preview'];
        var isIframePreview = options.preview === 'iframe';
        
        // 追加 Tab 组件
        var elemView = $('<div class="'+ CONST.ELEM_PREVIEW +'">');
        var elemTabView = $('<div class="layui-tab layui-tab-brief">');
        var elemHeaderView = $('<div class="layui-tab-title">');
        var elemPreviewView = $('<div class="'+ [
          CONST.ELEM_ITEM, 
          CONST.ELEM_ITEM +'-preview',
          'layui-border'
        ].join(' ') +'">');
        var elemToolbar = $('<div class="layui-code-tools"></div>');
        var elemViewHas = othis.prev('.' + CONST.ELEM_PREVIEW);
        var elemPreviewViewHas = othis.next('.' + CONST.ELEM_ITEM +'-preview');

        if(options.id) elemView.attr('id', options.id);
        elemTabView.attr('lay-filter', FILTER_VALUE);

        // 标签头
        layui.each(layout, function(i, v){
          var li = $('<li lay-id="'+ v +'">');
          if(i === 0) li.addClass('layui-this');
          li.html(options.text[v]);
          elemHeaderView.append(li);
        });

        // 工具栏
        var tools = {
          'full': {
            className: 'screen-full',
            title: ['最大化显示', '还原显示'],
            event: function(el, type){
              var elemView = el.closest('.'+ CONST.ELEM_PREVIEW);
              var classNameFull = 'layui-icon-'+ this.className;
              var classNameRestore = 'layui-icon-screen-restore';
              var title = this.title;
              var html = $('html,body');
              var ELEM_SCOLLBAR_HIDE = 'layui-scollbar-hide';

              if(el.hasClass(classNameFull)){
                elemView.addClass(CONST.ELEM_FULL);
                el.removeClass(classNameFull).addClass(classNameRestore);
                el.attr('title', title[1]);
                html.addClass(ELEM_SCOLLBAR_HIDE);
              } else {
                elemView.removeClass(CONST.ELEM_FULL);
                el.removeClass(classNameRestore).addClass(classNameFull);
                el.attr('title', title[0]);
                html.removeClass(ELEM_SCOLLBAR_HIDE);
              }
            }
          },
          'window': {
            className: 'release',
            title: ['在新窗口预览'],
            event: function(el, type){
              util.openWin({
                content: codes.join('')
              });
            }
          }
        };
        elemToolbar.on('click', '>i', function(){ // 工具栏事件
          var oi = $(this);
          var type = oi.data('type');
          typeof tools[type].event === 'function' && tools[type].event(oi, type);
          typeof options.toolsEvent === 'function' && options.toolsEvent(oi, type);
        });
        layui.each(options.tools, function(i, v){
          var className = (tools[v] && tools[v].className) || v;
          var title = tools[v].title || [''];
          elemToolbar.append(
            '<i class="layui-icon layui-icon-'+ className +'" data-type="'+ v +'" title="'+ title[0] +'"></i>'
          );
        });

        // 移除旧结构
        if(elemViewHas[0]) elemViewHas.remove();
        if(elemPreviewViewHas[0]) elemPreviewViewHas.remove();

        elemTabView.append(elemHeaderView); // 追加标签头
        options.tools && elemTabView.append(elemToolbar); // 追加工具栏
        othis.wrap(elemView).addClass(CONST.ELEM_ITEM).before(elemTabView); // 追加标签结构

        
        // 追加预览
        if(isIframePreview){
          elemPreviewView.html('<iframe></iframe>');
        }

        // 执行预览
        var run = function(thisItemBody){
          var iframe = thisItemBody.children('iframe')[0];
          if(isIframePreview && iframe){
            iframe.srcdoc = codes.join('');
          } else {
            thisItemBody.html(codes.join(''));
          }
          // 回调的返回参数
          var params = {
            container: thisItemBody,
            render: function(){
              form.render(thisItemBody.find('.layui-form'));
              element.render();
            }
          };
          // 当前实例预览完毕后的回调
          setTimeout(function(){
            typeof options.done === 'function' && options.done(params);
          },3);
        };

        if(layout[0] === 'preview'){
          elemPreviewView.addClass(CONST.ELEM_SHOW);
          othis.before(elemPreviewView);
          run(elemPreviewView);
        } else {
          othis.addClass(CONST.ELEM_SHOW).after(elemPreviewView);
        }

        // 内容项初始化样式
        options.codeStyle = [options.style, options.codeStyle].join('');
        options.previewStyle = [options.style, options.previewStyle].join('');
        // othis.attr('style', options.codeStyle);
        elemPreviewView.attr('style', options.previewStyle);

        // tab change
        element.on('tab('+ FILTER_VALUE +')', function(data){
          var $this = $(this);
          var thisElem = $(data.elem).closest('.'+ CONST.ELEM_PREVIEW);
          var elemItemBody = thisElem.find('.'+ CONST.ELEM_ITEM);
          var thisItemBody = elemItemBody.eq(data.index);
          
          elemItemBody.removeClass(CONST.ELEM_SHOW);
          thisItemBody.addClass(CONST.ELEM_SHOW);

          if($this.attr('lay-id') === 'preview'){
            run(thisItemBody);
          }
        });
      }


      // 有序或无序列表
      var listTag = options.ln ? 'ol' : 'ul';
      var listElem = $('<'+ listTag +' class="layui-code-'+ listTag +'">');

      // header
      var headerElem = $('<div class="'+ CONST.ELEM_TITLE +'">');

      // 添加组件 clasName
      othis.addClass('layui-code-view layui-box');

      // 自定义风格
      if(options.skin){
        if(options.skin === 'notepad') options.skin = 'dark';
        othis.addClass('layui-code-'+ options.skin);
      } 

      // 转义 HTML 标签
      if(options.encode) html = util.escape(html);
      html = html.replace(/[\r\t\n]+/g, '</li><li>'); // 转义换行符
      
      // 生成列表
      othis.html(listElem.html('<li>' + html + '</li>'));
      
      // 创建 header
      if(options.header && !othis.children('.'+ CONST.ELEM_TITLE)[0]){
        headerElem.html(options.title + (
          options.about 
            ? '<div class="layui-code-about">' + options.about + '</div>'
          : ''
        ));
        othis.prepend(headerElem);
      }

      // 所有实例渲染完毕后的回调
      if(options.elem.length === index + 1){
        typeof options.allDone === 'function' && options.allDone();
      }

      // 按行数适配左边距
      (function(autoIncNums){
        if(autoIncNums > 0){
          listElem.css('margin-left', autoIncNums + 'px');
        }
      })(Math.floor(listElem.find('li').length/100));

      // 限制 Code 最大高度
      if(options.height){ // 兼容旧版本
        listElem.css('max-height', options.height);
      }
      // Code 内容区域样式
      listElem.attr('style', options.codeStyle);

    });
    
  });
});

// 若为源码版，则自动加载该组件依赖的 css 文件
if(!layui['layui.all']){
  layui.addcss('modules/code.css?v=3', 'skincodecss');
}