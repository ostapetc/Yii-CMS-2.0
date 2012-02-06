(function($) {
  $.fn.closeDebugger = function(divId) {
    $("#"+divId).remove();
  }
  $.debug = function(variable, options) {
    // define defaults and override with options, if available
    // by extending the default settings, we don't modify the argument
    var settings = $.extend({
      divId: "debugDiv",
      divCss: {
        "border": "1px solid #AAA",
        "background": "#FFF",
        "padding": "15px",
        "width": "70%",
        "position": "fixed",
        "top": "60px",
        "left": "10%",
        "z-index": "2000",
        "color:": "#444"
      },
      spanId: "debugSpanTitle",
      spanText: "Object Properties",
      objectInfoId: "debugObjectInfo",
      recursive: true
    }, options);

    var vars = {
      debugContainer: $('<div style="text-align:left;" id="'+settings.divId+
        '" ><span id="'+settings.spanId+
        '">'+settings.spanText+
        '</span>'+
        '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'+
        '<a href="javascript:void(0);" onclick="$().closeDebugger(\''+settings.divId+'\');">Close</a>'+
        '<hr /><div id="'+settings.objectInfoId+
        '"></div></div>')
    }

      var object = variable;
      if(variable == undefined){
        object = this;
        settings.recursive = false;
      }
      printDebug(object);

    function typeOf(value) {
      var s = typeof value;
      if (s === 'object') {
        if (value) {
          if (typeof value.length === 'number' &&
            !(value.propertyIsEnumerable('length')) &&
            typeof value.splice === 'function') {
            s = 'array';
          }
        } else {
          s = 'null';
        }
      }
      return s;
    }


    function printDebug(obj){
      //create the div to display debuggable object
      createDebugDiv();
      //get object html
      var html = getObjectHtml(obj);
      //set little div to object html
      $("#"+settings.objectInfoId).html(html);
    }

    function createDebugDiv(){
      //remove all existing debugDivs
      $("#"+settings.divId).remove();
      //apply css
      $(vars.debugContainer).css(settings.divCss);
      $('body').append(vars.debugContainer);
    }

    function getObjectHtml(obj){
      var html = "";
      var br   = "<br />";
      //html += obj.innerHTML+br;
      if(obj.innerHTML != undefined){
        html += doHtmlElementHtml(obj);
        return html;
      }
      else if(typeof obj == "string" ){
        html += "String: "+obj+br;
        return html;
      }
      else if(typeof obj == "number" ){
        html += "Number: "+obj+br;
        return html;
      }
      else if(typeof obj == "boolean" ){
        html += "Boolean: "+obj+br;
        return html;
      }
      else if(obj instanceof Function){
        html += formatFunction(obj);
      }
      for (var prop in obj) {
        if(prop != "prototype"){
          
          if(obj[prop] instanceof Array && settings.recursive){
            html += doArrayHtml(obj, prop);
          }
          else if(obj[prop] instanceof Function && settings.recursive){
            html += doFunctionHtml(obj, prop);
          }
          else if(obj[prop] instanceof Object && settings.recursive){
            html += doObjectHtml(obj, prop);
          }
          else{
            html += "<span style=\"display:block;\">"+prop+": "+obj[prop]+"</span>";
          }
        }
      }
      return html;
    }

    function doHtmlElementHtml(obj){
      var html = "";
      var currentElement = "";
      var desiredElements = new Array(
        "tagName",
        "className",
        "id",
        "title",
        "tabIndex",
        "align",
        "scrollWidth",
        "clientLeft",
        "clientHeight",
        "clientWidth",
        "clientTop",
        "innerHTML",
        "textContent"
        );
      for(var prop in desiredElements){
        currentElement = desiredElements[prop];
        html += "<span style=\"display:block\">"+currentElement+": "+obj[currentElement]+"</span>";
      }
      return html;
    }

    function doArrayHtml(obj, prop){
      var id= getUniqueId(prop);
      return '<a href="javascript:void(0);" style="display:block;" onclick="$(\'#'+id+'\').toggle();">Array: '+
      prop+'...</a><div style="display:none;padding-left:15px;" id="'+id+
      '">'+getObjectHtml(obj[prop])+'</div>';
    }

    function doFunctionHtml(obj, prop){
      var id= getUniqueId(prop);
      return '<a href="javascript:void(0);" style="display:block;" onclick="$(\'#'+id+'\').toggle();">Function: '+
      prop+'...</a><div style="display:none;padding-left:15px;" id="'+id+
      '">'+formatFunction(obj[prop])+'</div>';
    }

    function doObjectHtml(obj, prop){
      var id= getUniqueId(prop);
      return '<a href="javascript:void(0);" style="display:block;" onclick="$(\'#'+id+'\').toggle();">Object: '+
      prop+'...</a><div style="display:none;padding-left:15px;" id="'+id+
      '">'+getObjectHtml(obj[prop])+'</div>';
    }

    function getUniqueId(property){
      var t = new Date();
      var randomnumber = Math.floor(Math.random()*110)
      return "div"+property+"-"+t.getTime()+randomnumber;
    }

    function formatFunction(str){
      return "<pre>"+str+"</pre>";
    }

  }
})(jQuery);

