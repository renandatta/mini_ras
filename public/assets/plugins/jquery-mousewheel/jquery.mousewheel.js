!function(e){"function"==typeof define&&define.amd?define(["jquery"],e):"object"==typeof exports?module.exports=e:e(jQuery)}((function(e){var t,i,n=["wheel","mousewheel","DOMMouseScroll","MozMousePixelScroll"],o="onwheel"in document||document.documentMode>=9?["wheel"]:["mousewheel","DomMouseScroll","MozMousePixelScroll"],l=Array.prototype.slice;if(e.event.fixHooks)for(var s=n.length;s;)e.event.fixHooks[n[--s]]=e.event.mouseHooks;var a=e.event.special.mousewheel={version:"3.1.12",setup:function(){if(this.addEventListener)for(var t=o.length;t;)this.addEventListener(o[--t],h,!1);else this.onmousewheel=h;e.data(this,"mousewheel-line-height",a.getLineHeight(this)),e.data(this,"mousewheel-page-height",a.getPageHeight(this))},teardown:function(){if(this.removeEventListener)for(var t=o.length;t;)this.removeEventListener(o[--t],h,!1);else this.onmousewheel=null;e.removeData(this,"mousewheel-line-height"),e.removeData(this,"mousewheel-page-height")},getLineHeight:function(t){var i=e(t),n=i["offsetParent"in e.fn?"offsetParent":"parent"]();return n.length||(n=e("body")),parseInt(n.css("fontSize"),10)||parseInt(i.css("fontSize"),10)||16},getPageHeight:function(t){return e(t).height()},settings:{adjustOldDeltas:!0,normalizeOffset:!0}};function h(n){var o=n||window.event,s=l.call(arguments,1),h=0,f=0,d=0,c=0,m=0,g=0;if((n=e.event.fix(o)).type="mousewheel","detail"in o&&(d=-1*o.detail),"wheelDelta"in o&&(d=o.wheelDelta),"wheelDeltaY"in o&&(d=o.wheelDeltaY),"wheelDeltaX"in o&&(f=-1*o.wheelDeltaX),"axis"in o&&o.axis===o.HORIZONTAL_AXIS&&(f=-1*d,d=0),h=0===d?f:d,"deltaY"in o&&(h=d=-1*o.deltaY),"deltaX"in o&&(f=o.deltaX,0===d&&(h=-1*f)),0!==d||0!==f){if(1===o.deltaMode){var w=e.data(this,"mousewheel-line-height");h*=w,d*=w,f*=w}else if(2===o.deltaMode){var v=e.data(this,"mousewheel-page-height");h*=v,d*=v,f*=v}if(c=Math.max(Math.abs(d),Math.abs(f)),(!i||c<i)&&(i=c,u(o,c)&&(i/=40)),u(o,c)&&(h/=40,f/=40,d/=40),h=Math[h>=1?"floor":"ceil"](h/i),f=Math[f>=1?"floor":"ceil"](f/i),d=Math[d>=1?"floor":"ceil"](d/i),a.settings.normalizeOffset&&this.getBoundingClientRect){var p=this.getBoundingClientRect();m=n.clientX-p.left,g=n.clientY-p.top}return n.deltaX=f,n.deltaY=d,n.deltaFactor=i,n.offsetX=m,n.offsetY=g,n.deltaMode=0,s.unshift(n,h,f,d),t&&clearTimeout(t),t=setTimeout(r,200),(e.event.dispatch||e.event.handle).apply(this,s)}}function r(){i=null}function u(e,t){return a.settings.adjustOldDeltas&&"mousewheel"===e.type&&t%120==0}e.fn.extend({mousewheel:function(e){return e?this.bind("mousewheel",e):this.trigger("mousewheel")},unmousewheel:function(e){return this.unbind("mousewheel",e)}})}));