/**
 * @license
 * Copyright (c) 2018 amCharts (Antanas Marcelionis, Martynas Majeris)
 *
 * This sofware is provided under multiple licenses. Please see below for
 * links to appropriate usage.
 *
 * Free amCharts linkware license. Details and conditions:
 * https://github.com/amcharts/amcharts4/blob/master/LICENSE
 *
 * One of the amCharts commercial licenses. Details and pricing:
 * https://www.amcharts.com/online-store/
 * https://www.amcharts.com/online-store/licenses-explained/
 *
 * If in doubt, contact amCharts at contact@amcharts.com
 *
 * PLEASE DO NOT REMOVE THIS COPYRIGHT NOTICE.
 * @hidden
 */
am4internal_webpackJsonp(["2ff7"],{V3Xd:function(e,t,r){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var i={};r.d(i,"PointedCircle",function(){return c}),r.d(i,"PinBullet",function(){return y}),r.d(i,"FlagBullet",function(){return m}),r.d(i,"Star",function(){return C});var n=r("m4/l"),a=r("1qam"),o=r("aCit"),s=r("hGwe"),l=r("Gg2j"),c=function(e){function t(){var t=e.call(this)||this;return t.className="PointedCircle",t.element=t.paper.add("path"),t.radius=18,t.pointerAngle=90,t.applyTheme(),t}return n.c(t,e),t.prototype.draw=function(){e.prototype.draw.call(this);var t=this.pointerBaseWidth,r=this.pointerLength;r<=.001&&(r=.001);var i=this.pointerAngle+180,n=this.radius;t>2*n&&(t=2*n);var a=this.pointerX,o=this.pointerY,c=s.moveTo({x:a,y:a}),u=l.DEGREES*Math.atan(t/2/r);u<=.001&&(u=.001);var p=i-u,h=i+u;c+=s.lineTo({x:a+r*l.cos(p),y:o+r*l.sin(p)}),c+=s.arcToPoint({x:a+r*l.cos(h),y:o+r*l.sin(h)},n,n,!0,!0),c+=s.lineTo({x:a,y:a}),this.path=c},Object.defineProperty(t.prototype,"radius",{get:function(){return this.getPropertyValue("radius")},set:function(e){this.setPropertyValue("radius",e,!0)},enumerable:!0,configurable:!0}),Object.defineProperty(t.prototype,"pointerAngle",{get:function(){return this.getPropertyValue("pointerAngle")},set:function(e){this.setPropertyValue("pointerAngle",e,!0)},enumerable:!0,configurable:!0}),t}(a.a);o.b.registeredClasses.PointerCircle=c;var u=r("TXRX"),p=r("FzPm"),h=r("tjMS"),d=r("MIZb"),y=function(e){function t(){var t=e.call(this)||this;t.className="PinBullet";var r=new d.a,i=t.createChild(p.a);i.shouldClone=!1,i.isMeasured=!1,i.fill=r.getFor("background"),i.radius=Object(h.c)(85),t.circle=i;var n=t.background;return n.fill=r.getFor("alternativeBackground"),n.fillOpacity=1,n.pointerBaseWidth=20,n.pointerLength=20,n.radius=25,n.events.on("propertychanged",t.invalidate,t,!1),t.applyTheme(),t}return n.c(t,e),t.prototype.validate=function(){e.prototype.validate.call(this);var t=this.background,r=t.pointerX,i=t.pointerY,n=t.pointerLength,a=t.pointerBaseWidth,o=t.pointerAngle+180,s=t.radius;a>2*s&&(a=2*s);var c=l.DEGREES*Math.atan(a/2/n);c<=.001&&(c=.001);var u=o-c,p=o+c,d={x:r+n*l.cos(u),y:i+n*l.sin(u)},y={x:r+n*l.cos(p),y:i+n*l.sin(p)},g=d.x,f=y.x,b=d.y,m=y.y,v=s*s,P=Math.sqrt((f-g)*(f-g)+(m-b)*(m-b)),x=(g+f)/2-Math.sqrt(v-P/2*(P/2))*((b-m)/P),C=(b+m)/2-Math.sqrt(v-P/2*(P/2))*((f-g)/P);this.circle&&(this.circle.radius instanceof h.a&&(this.circle.width=2*s,this.circle.height=2*s));var V=this.image;V?(V.x=x,V.y=C,V.width=2*s,V.height=2*s,V.element.attr({preserveAspectRatio:"xMidYMid slice"}),this.circle&&(this.circle.scale=1/V.scale)):this.circle&&(this.circle.x=x,this.circle.y=C);var O=this.label;O&&(O.x=x,O.y=C)},Object.defineProperty(t.prototype,"image",{get:function(){return this._image},set:function(e){e&&(this._image=e,this._disposers.push(e),e.shouldClone=!1,e.parent=this,e.horizontalCenter="middle",e.verticalCenter="middle",this.circle&&(e.mask=this.circle))},enumerable:!0,configurable:!0}),Object.defineProperty(t.prototype,"label",{get:function(){return this._label},set:function(e){e&&(this._label=e,this._disposers.push(e),e.shouldClone=!1,e.parent=this,e.horizontalCenter="middle",e.verticalCenter="middle",e.textAlign="middle",e.dy=2)},enumerable:!0,configurable:!0}),t.prototype.copyFrom=function(t){e.prototype.copyFrom.call(this,t),t.image&&(this._image||(this.image=t.image.clone()),this._image.copyFrom(t.image)),this.circle&&t.circle&&this.circle.copyFrom(t.circle)},t.prototype.createBackground=function(){return new c},t}(u.a);o.b.registeredClasses.PinBullet=y;var g=r("p9TX"),f=r("w4m0"),b=r("PTiM"),m=function(e){function t(){var t=e.call(this)||this;t.className="FlagBullet";var r=t.background;r.fillOpacity=1,r.events.on("propertychanged",t.invalidate,t,!1),r.waveHeight=1.5,r.waveLength=7,r.setWavedSides(!0,!1,!0,!1),r.strokeOpacity=1;var i=new d.a;t.stroke=i.getFor("alternativeBackground"),t.pole=t.createChild(b.a),t.pole.strokeOpacity=1,t.width=22,t.height=16;var n=new g.a;return n.padding(3,5,3,5),n.dy=1,n.events.on("propertychanged",t.invalidate,t,!1),n.events.on("positionchanged",t.invalidate,t,!1),n.strokeOpacity=0,t.label=n,t.poleHeight=10,t.applyTheme(),t}return n.c(t,e),t.prototype.validate=function(){e.prototype.validate.call(this),this.updateBackground();var t=this.background;this.pole.y1=0;var r=this.poleHeight,i=this.label,n=t.pixelHeight;r>0?(this.pole.y2=-r-n,i&&(i.y=-r-n)):(this.pole.y2=-r+n,i&&(i.y=-r)),i&&"middle"==i.horizontalCenter&&(this.pole.y2=-r)},t.prototype.updateBackground=function(){var e=this._background;if(e){var t=this.label;t?(e.x=t.maxLeft,e.width=t.measuredWidth,e.height=t.measuredHeight):(e.width=Math.abs(this.maxRight-this.maxLeft),e.height=Math.abs(this.maxBottom-this.maxTop));var r=this.poleHeight;e.y=r>0?-r-e.pixelHeight:-r}},Object.defineProperty(t.prototype,"label",{get:function(){return this._label},set:function(e){e?(this._label=e,this._disposers.push(e),e.parent=this,e.shouldClone=!1):(this._label&&this._label.dispose(),this._label=e,this.invalidate())},enumerable:!0,configurable:!0}),t.prototype.copyFrom=function(t){t.label&&(this.label=t.label.clone()),t.pole&&this.pole.copyFrom(t.pole),e.prototype.copyFrom.call(this,t)},t.prototype.createBackground=function(){return new f.a},Object.defineProperty(t.prototype,"poleHeight",{get:function(){return this.getPropertyValue("poleHeight")},set:function(e){this.setPropertyValue("poleHeight",e,!0)},enumerable:!0,configurable:!0}),t}(u.a);o.b.registeredClasses.FlagBullet=m;var v=r("Vs7R"),P=r("Mtpk"),x=r("v9UT"),C=function(e){function t(){var t=e.call(this)||this;return t.className="Star",t.pointCount=5,t.arc=360,t.radius=100,t.innerRadius=Object(h.c)(30),t.cornerRadius=0,t.innerCornerRadius=0,t.startAngle=-90,t.element=t.paper.add("path"),t.applyTheme(),t}return n.c(t,e),t.prototype.draw=function(){e.prototype.draw.call(this);var t=this.startAngle,r=this.arc,i=this.pointCount,n=this.radius,a=this.pixelInnerRadius,o=this.cornerRadius;o>n-a&&(o=n-a);var c=this.innerCornerRadius;c>n-o-a&&(c=n-o-a);for(var u=r/i/2,p="",h=0;h<i;h++){var d=t+h*r/i;if(o>0){var y={x:a*l.cos(d-u),y:a*l.sin(d-u)},g={x:n*l.cos(d),y:n*l.sin(d)},f={x:a*l.cos(d+u),y:a*l.sin(d+u)},b=l.getAngle(g,y),m=l.getAngle(g,f),v=g.x+o*l.cos(b),P=g.y+o*l.sin(b),x=g.x+o*l.cos(m),C=g.y+o*l.sin(m);p+=s.lineTo({x:v,y:P}),p+=" Q"+g.x+","+g.y+" "+x+","+C}else p+=s.lineTo({x:n*l.cos(d),y:n*l.sin(d)});if(d+=u,c>0){y={x:n*l.cos(d-u),y:n*l.sin(d-u)},g={x:a*l.cos(d),y:a*l.sin(d)},f={x:n*l.cos(d+u),y:n*l.sin(d+u)},b=l.getAngle(g,y),m=l.getAngle(g,f),v=g.x+c*l.cos(b),P=g.y+c*l.sin(b),x=g.x+c*l.cos(m),C=g.y+c*l.sin(m);p+=s.lineTo({x:v,y:P}),p+=" Q"+g.x+","+g.y+" "+x+","+C}else p+=s.lineTo({x:a*l.cos(d),y:a*l.sin(d)})}this.arc<360&&(p+=s.lineTo({x:0,y:0})),p=(p+=s.closePath()).replace("L","M"),this.path=p},Object.defineProperty(t.prototype,"startAngle",{get:function(){return this.getPropertyValue("startAngle")},set:function(e){this.setPropertyValue("startAngle",l.normalizeAngle(e),!0)},enumerable:!0,configurable:!0}),Object.defineProperty(t.prototype,"arc",{get:function(){return this.getPropertyValue("arc")},set:function(e){P.isNumber(e)||(e=360),this.setPropertyValue("arc",e,!0)},enumerable:!0,configurable:!0}),Object.defineProperty(t.prototype,"radius",{get:function(){var e=this.getPropertyValue("radius");return P.isNumber(e)||(e=0),e},set:function(e){this.setPropertyValue("radius",e,!0)},enumerable:!0,configurable:!0}),Object.defineProperty(t.prototype,"radiusY",{get:function(){var e=this.getPropertyValue("radiusY");return P.isNumber(e)||(e=this.radius),e},set:function(e){this.setPropertyValue("radiusY",e,!0)},enumerable:!0,configurable:!0}),Object.defineProperty(t.prototype,"innerRadius",{get:function(){return this.getPropertyValue("innerRadius")},set:function(e){this.setPercentProperty("innerRadius",e,!0,!1,10,!1)},enumerable:!0,configurable:!0}),Object.defineProperty(t.prototype,"pixelInnerRadius",{get:function(){return x.relativeToValue(this.innerRadius,this.radius)},enumerable:!0,configurable:!0}),Object.defineProperty(t.prototype,"cornerRadius",{get:function(){return this.getPropertyValue("cornerRadius")},set:function(e){this.setPropertyValue("cornerRadius",e,!0)},enumerable:!0,configurable:!0}),Object.defineProperty(t.prototype,"innerCornerRadius",{get:function(){return this.getPropertyValue("innerCornerRadius")},set:function(e){this.setPropertyValue("innerCornerRadius",e,!0)},enumerable:!0,configurable:!0}),Object.defineProperty(t.prototype,"pointCount",{get:function(){var e=this.getPropertyValue("pointCount");return l.max(3,e)},set:function(e){this.setPropertyValue("pointCount",e,!0)},enumerable:!0,configurable:!0}),t}(v.a);o.b.registeredClasses.Star=C,window.am4plugins_bullets=i}},["V3Xd"]);
//# sourceMappingURL=bullets.js.map