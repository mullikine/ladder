/*

http://www.dustindiaz.com/add-remove-elements-reprise/

*/

var Dom = {
  get: function(el) {
    if (typeof el === 'string') {
      return document.getElementById(el);
    } else {
      return el;
    }
  },
  add: function(el, dest) {
    var el = this.get(el);
    var dest = this.get(dest);
    dest.appendChild(el);
  },
  remove: function(el) {
    var el = this.get(el);
    el.parentNode.removeChild(el);
  }
  };
  var Event = {
  add: function() {
    if (window.addEventListener) {
      return function(el, type, fn) {
        Dom.get(el).addEventListener(type, fn, false);
      };
    } else if (window.attachEvent) {
      return function(el, type, fn) {
        var f = function() {
          fn.call(Dom.get(el), window.event);
        };
        Dom.get(el).attachEvent('on' + type, f);
      };
    }
  }()
 };
 
 /*
 
 Event.add(window, 'load', function() {
  var i = 0;
  Event.add('add-element', 'click', function() {
    var el = document.createElement('p');
    el.innerHTML = 'Remove This Element (' + ++i + ')';
    Dom.add(el, 'content');
    Event.add(el, 'click', function(e) {
      Dom.remove(this);
    });
  });
});

*/