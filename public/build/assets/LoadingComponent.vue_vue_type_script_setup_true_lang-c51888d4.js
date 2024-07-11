var pe=Object.defineProperty;var i=(t,n)=>pe(t,"name",{value:n,configurable:!0});import{d as Fn,C as V,H as be,ah as ge,o as he,c as ye,f as ke,U as we,u as ln,e as xe}from"./main-9b499219.js";var Ae={prefix:"fas",iconName:"spinner",icon:[512,512,[],"f110","M304 48a48 48 0 1 0 -96 0 48 48 0 1 0 96 0zm0 416a48 48 0 1 0 -96 0 48 48 0 1 0 96 0zM48 304a48 48 0 1 0 0-96 48 48 0 1 0 0 96zm464-48a48 48 0 1 0 -96 0 48 48 0 1 0 96 0zM142.9 437A48 48 0 1 0 75 369.1 48 48 0 1 0 142.9 437zm0-294.2A48 48 0 1 0 75 75a48 48 0 1 0 67.9 67.9zM369.1 437A48 48 0 1 0 437 369.1 48 48 0 1 0 369.1 437z"]};function cn(t,n){var e=Object.keys(t);if(Object.getOwnPropertySymbols){var a=Object.getOwnPropertySymbols(t);n&&(a=a.filter(function(r){return Object.getOwnPropertyDescriptor(t,r).enumerable})),e.push.apply(e,a)}return e}i(cn,"ownKeys$1");function m(t){for(var n=1;n<arguments.length;n++){var e=arguments[n]!=null?arguments[n]:{};n%2?cn(Object(e),!0).forEach(function(a){S(t,a,e[a])}):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(e)):cn(Object(e)).forEach(function(a){Object.defineProperty(t,a,Object.getOwnPropertyDescriptor(e,a))})}return t}i(m,"_objectSpread2$1");function At(t){"@babel/helpers - typeof";return At=typeof Symbol=="function"&&typeof Symbol.iterator=="symbol"?function(n){return typeof n}:function(n){return n&&typeof Symbol=="function"&&n.constructor===Symbol&&n!==Symbol.prototype?"symbol":typeof n},At(t)}i(At,"_typeof$1");function Oe(t,n){if(!(t instanceof n))throw new TypeError("Cannot call a class as a function")}i(Oe,"_classCallCheck");function un(t,n){for(var e=0;e<n.length;e++){var a=n[e];a.enumerable=a.enumerable||!1,a.configurable=!0,"value"in a&&(a.writable=!0),Object.defineProperty(t,a.key,a)}}i(un,"_defineProperties");function Se(t,n,e){return n&&un(t.prototype,n),e&&un(t,e),Object.defineProperty(t,"prototype",{writable:!1}),t}i(Se,"_createClass");function S(t,n,e){return n in t?Object.defineProperty(t,n,{value:e,enumerable:!0,configurable:!0,writable:!0}):t[n]=e,t}i(S,"_defineProperty$1");function Vt(t,n){return Ee(t)||_e(t,n)||jn(t,n)||Ne()}i(Vt,"_slicedToArray");function lt(t){return Pe(t)||Ce(t)||jn(t)||Ie()}i(lt,"_toConsumableArray");function Pe(t){if(Array.isArray(t))return Ft(t)}i(Pe,"_arrayWithoutHoles");function Ee(t){if(Array.isArray(t))return t}i(Ee,"_arrayWithHoles");function Ce(t){if(typeof Symbol<"u"&&t[Symbol.iterator]!=null||t["@@iterator"]!=null)return Array.from(t)}i(Ce,"_iterableToArray");function _e(t,n){var e=t==null?null:typeof Symbol<"u"&&t[Symbol.iterator]||t["@@iterator"];if(e!=null){var a=[],r=!0,o=!1,s,f;try{for(e=e.call(t);!(r=(s=e.next()).done)&&(a.push(s.value),!(n&&a.length===n));r=!0);}catch(l){o=!0,f=l}finally{try{!r&&e.return!=null&&e.return()}finally{if(o)throw f}}return a}}i(_e,"_iterableToArrayLimit");function jn(t,n){if(t){if(typeof t=="string")return Ft(t,n);var e=Object.prototype.toString.call(t).slice(8,-1);if(e==="Object"&&t.constructor&&(e=t.constructor.name),e==="Map"||e==="Set")return Array.from(t);if(e==="Arguments"||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(e))return Ft(t,n)}}i(jn,"_unsupportedIterableToArray");function Ft(t,n){(n==null||n>t.length)&&(n=t.length);for(var e=0,a=new Array(n);e<n;e++)a[e]=t[e];return a}i(Ft,"_arrayLikeToArray");function Ie(){throw new TypeError(`Invalid attempt to spread non-iterable instance.
In order to be iterable, non-array objects must have a [Symbol.iterator]() method.`)}i(Ie,"_nonIterableSpread");function Ne(){throw new TypeError(`Invalid attempt to destructure non-iterable instance.
In order to be iterable, non-array objects must have a [Symbol.iterator]() method.`)}i(Ne,"_nonIterableRest");var mn=i(function(){},"noop"),qt={},Dn={},Yn=null,$n={mark:mn,measure:mn};try{typeof window<"u"&&(qt=window),typeof document<"u"&&(Dn=document),typeof MutationObserver<"u"&&(Yn=MutationObserver),typeof performance<"u"&&($n=performance)}catch{}var Te=qt.navigator||{},dn=Te.userAgent,vn=dn===void 0?"":dn,U=qt,w=Dn,pn=Yn,mt=$n;U.document;var D=!!w.documentElement&&!!w.head&&typeof w.addEventListener=="function"&&typeof w.createElement=="function",Un=~vn.indexOf("MSIE")||~vn.indexOf("Trident/"),dt,vt,pt,bt,gt,R="___FONT_AWESOME___",jt=16,Bn="fa",Wn="svg-inline--fa",X="data-fa-i2svg",Dt="data-fa-pseudo-element",Me="data-fa-pseudo-element-pending",Qt="data-prefix",Zt="data-icon",bn="fontawesome-i2svg",ze="async",Le=["HTML","HEAD","STYLE","SCRIPT"],Hn=function(){try{return!0}catch{return!1}}(),k="classic",x="sharp",Jt=[k,x];function ct(t){return new Proxy(t,{get:i(function(e,a){return a in e?e[a]:e[k]},"get")})}i(ct,"familyProxy");var rt=ct((dt={},S(dt,k,{fa:"solid",fas:"solid","fa-solid":"solid",far:"regular","fa-regular":"regular",fal:"light","fa-light":"light",fat:"thin","fa-thin":"thin",fad:"duotone","fa-duotone":"duotone",fab:"brands","fa-brands":"brands",fak:"kit",fakd:"kit","fa-kit":"kit","fa-kit-duotone":"kit"}),S(dt,x,{fa:"solid",fass:"solid","fa-solid":"solid",fasr:"regular","fa-regular":"regular",fasl:"light","fa-light":"light",fast:"thin","fa-thin":"thin"}),dt)),it=ct((vt={},S(vt,k,{solid:"fas",regular:"far",light:"fal",thin:"fat",duotone:"fad",brands:"fab",kit:"fak"}),S(vt,x,{solid:"fass",regular:"fasr",light:"fasl",thin:"fast"}),vt)),ot=ct((pt={},S(pt,k,{fab:"fa-brands",fad:"fa-duotone",fak:"fa-kit",fal:"fa-light",far:"fa-regular",fas:"fa-solid",fat:"fa-thin"}),S(pt,x,{fass:"fa-solid",fasr:"fa-regular",fasl:"fa-light",fast:"fa-thin"}),pt)),Re=ct((bt={},S(bt,k,{"fa-brands":"fab","fa-duotone":"fad","fa-kit":"fak","fa-light":"fal","fa-regular":"far","fa-solid":"fas","fa-thin":"fat"}),S(bt,x,{"fa-solid":"fass","fa-regular":"fasr","fa-light":"fasl","fa-thin":"fast"}),bt)),Fe=/fa(s|r|l|t|d|b|k|ss|sr|sl|st)?[\-\ ]/,Gn="fa-layers-text",je=/Font ?Awesome ?([56 ]*)(Solid|Regular|Light|Thin|Duotone|Brands|Free|Pro|Sharp|Kit)?.*/i,De=ct((gt={},S(gt,k,{900:"fas",400:"far",normal:"far",300:"fal",100:"fat"}),S(gt,x,{900:"fass",400:"fasr",300:"fasl",100:"fast"}),gt)),Xn=[1,2,3,4,5,6,7,8,9,10],Ye=Xn.concat([11,12,13,14,15,16,17,18,19,20]),$e=["class","data-prefix","data-icon","data-fa-transform","data-fa-mask"],H={GROUP:"duotone-group",SWAP_OPACITY:"swap-opacity",PRIMARY:"primary",SECONDARY:"secondary"},st=new Set;Object.keys(it[k]).map(st.add.bind(st));Object.keys(it[x]).map(st.add.bind(st));var Ue=[].concat(Jt,lt(st),["2xs","xs","sm","lg","xl","2xl","beat","border","fade","beat-fade","bounce","flip-both","flip-horizontal","flip-vertical","flip","fw","inverse","layers-counter","layers-text","layers","li","pull-left","pull-right","pulse","rotate-180","rotate-270","rotate-90","rotate-by","shake","spin-pulse","spin-reverse","spin","stack-1x","stack-2x","stack","ul",H.GROUP,H.SWAP_OPACITY,H.PRIMARY,H.SECONDARY]).concat(Xn.map(function(t){return"".concat(t,"x")})).concat(Ye.map(function(t){return"w-".concat(t)})),et=U.FontAwesomeConfig||{};function Be(t){var n=w.querySelector("script["+t+"]");if(n)return n.getAttribute(t)}i(Be,"getAttrConfig");function We(t){return t===""?!0:t==="false"?!1:t==="true"?!0:t}i(We,"coerce");if(w&&typeof w.querySelector=="function"){var He=[["data-family-prefix","familyPrefix"],["data-css-prefix","cssPrefix"],["data-family-default","familyDefault"],["data-style-default","styleDefault"],["data-replacement-class","replacementClass"],["data-auto-replace-svg","autoReplaceSvg"],["data-auto-add-css","autoAddCss"],["data-auto-a11y","autoA11y"],["data-search-pseudo-elements","searchPseudoElements"],["data-observe-mutations","observeMutations"],["data-mutate-approach","mutateApproach"],["data-keep-original-source","keepOriginalSource"],["data-measure-performance","measurePerformance"],["data-show-missing-icons","showMissingIcons"]];He.forEach(function(t){var n=Vt(t,2),e=n[0],a=n[1],r=We(Be(e));r!=null&&(et[a]=r)})}var Kn={styleDefault:"solid",familyDefault:"classic",cssPrefix:Bn,replacementClass:Wn,autoReplaceSvg:!0,autoAddCss:!0,autoA11y:!0,searchPseudoElements:!1,observeMutations:!0,mutateApproach:"async",keepOriginalSource:!0,measurePerformance:!1,showMissingIcons:!0};et.familyPrefix&&(et.cssPrefix=et.familyPrefix);var J=m(m({},Kn),et);J.autoReplaceSvg||(J.observeMutations=!1);var d={};Object.keys(Kn).forEach(function(t){Object.defineProperty(d,t,{enumerable:!0,set:i(function(e){J[t]=e,at.forEach(function(a){return a(d)})},"set"),get:i(function(){return J[t]},"get")})});Object.defineProperty(d,"familyPrefix",{enumerable:!0,set:i(function(n){J.cssPrefix=n,at.forEach(function(e){return e(d)})},"set"),get:i(function(){return J.cssPrefix},"get")});U.FontAwesomeConfig=d;var at=[];function Ge(t){return at.push(t),function(){at.splice(at.indexOf(t),1)}}i(Ge,"onChange");var $=jt,z={size:16,x:0,y:0,rotate:0,flipX:!1,flipY:!1};function Xe(t){if(!(!t||!D)){var n=w.createElement("style");n.setAttribute("type","text/css"),n.innerHTML=t;for(var e=w.head.childNodes,a=null,r=e.length-1;r>-1;r--){var o=e[r],s=(o.tagName||"").toUpperCase();["STYLE","LINK"].indexOf(s)>-1&&(a=o)}return w.head.insertBefore(n,a),t}}i(Xe,"insertCss");var Ke="0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";function ft(){for(var t=12,n="";t-- >0;)n+=Ke[Math.random()*62|0];return n}i(ft,"nextUniqueId");function tt(t){for(var n=[],e=(t||[]).length>>>0;e--;)n[e]=t[e];return n}i(tt,"toArray");function tn(t){return t.classList?tt(t.classList):(t.getAttribute("class")||"").split(" ").filter(function(n){return n})}i(tn,"classArray");function Vn(t){return"".concat(t).replace(/&/g,"&amp;").replace(/"/g,"&quot;").replace(/'/g,"&#39;").replace(/</g,"&lt;").replace(/>/g,"&gt;")}i(Vn,"htmlEscape");function Ve(t){return Object.keys(t||{}).reduce(function(n,e){return n+"".concat(e,'="').concat(Vn(t[e]),'" ')},"").trim()}i(Ve,"joinAttributes");function Et(t){return Object.keys(t||{}).reduce(function(n,e){return n+"".concat(e,": ").concat(t[e].trim(),";")},"")}i(Et,"joinStyles");function nn(t){return t.size!==z.size||t.x!==z.x||t.y!==z.y||t.rotate!==z.rotate||t.flipX||t.flipY}i(nn,"transformIsMeaningful");function qe(t){var n=t.transform,e=t.containerWidth,a=t.iconWidth,r={transform:"translate(".concat(e/2," 256)")},o="translate(".concat(n.x*32,", ").concat(n.y*32,") "),s="scale(".concat(n.size/16*(n.flipX?-1:1),", ").concat(n.size/16*(n.flipY?-1:1),") "),f="rotate(".concat(n.rotate," 0 0)"),l={transform:"".concat(o," ").concat(s," ").concat(f)},u={transform:"translate(".concat(a/2*-1," -256)")};return{outer:r,inner:l,path:u}}i(qe,"transformForSvg");function Qe(t){var n=t.transform,e=t.width,a=e===void 0?jt:e,r=t.height,o=r===void 0?jt:r,s=t.startCentered,f=s===void 0?!1:s,l="";return f&&Un?l+="translate(".concat(n.x/$-a/2,"em, ").concat(n.y/$-o/2,"em) "):f?l+="translate(calc(-50% + ".concat(n.x/$,"em), calc(-50% + ").concat(n.y/$,"em)) "):l+="translate(".concat(n.x/$,"em, ").concat(n.y/$,"em) "),l+="scale(".concat(n.size/$*(n.flipX?-1:1),", ").concat(n.size/$*(n.flipY?-1:1),") "),l+="rotate(".concat(n.rotate,"deg) "),l}i(Qe,"transformForCss");var Ze=`:root, :host {
  --fa-font-solid: normal 900 1em/1 "Font Awesome 6 Solid";
  --fa-font-regular: normal 400 1em/1 "Font Awesome 6 Regular";
  --fa-font-light: normal 300 1em/1 "Font Awesome 6 Light";
  --fa-font-thin: normal 100 1em/1 "Font Awesome 6 Thin";
  --fa-font-duotone: normal 900 1em/1 "Font Awesome 6 Duotone";
  --fa-font-sharp-solid: normal 900 1em/1 "Font Awesome 6 Sharp";
  --fa-font-sharp-regular: normal 400 1em/1 "Font Awesome 6 Sharp";
  --fa-font-sharp-light: normal 300 1em/1 "Font Awesome 6 Sharp";
  --fa-font-sharp-thin: normal 100 1em/1 "Font Awesome 6 Sharp";
  --fa-font-brands: normal 400 1em/1 "Font Awesome 6 Brands";
}

svg:not(:root).svg-inline--fa, svg:not(:host).svg-inline--fa {
  overflow: visible;
  box-sizing: content-box;
}

.svg-inline--fa {
  display: var(--fa-display, inline-block);
  height: 1em;
  overflow: visible;
  vertical-align: -0.125em;
}
.svg-inline--fa.fa-2xs {
  vertical-align: 0.1em;
}
.svg-inline--fa.fa-xs {
  vertical-align: 0em;
}
.svg-inline--fa.fa-sm {
  vertical-align: -0.0714285705em;
}
.svg-inline--fa.fa-lg {
  vertical-align: -0.2em;
}
.svg-inline--fa.fa-xl {
  vertical-align: -0.25em;
}
.svg-inline--fa.fa-2xl {
  vertical-align: -0.3125em;
}
.svg-inline--fa.fa-pull-left {
  margin-right: var(--fa-pull-margin, 0.3em);
  width: auto;
}
.svg-inline--fa.fa-pull-right {
  margin-left: var(--fa-pull-margin, 0.3em);
  width: auto;
}
.svg-inline--fa.fa-li {
  width: var(--fa-li-width, 2em);
  top: 0.25em;
}
.svg-inline--fa.fa-fw {
  width: var(--fa-fw-width, 1.25em);
}

.fa-layers svg.svg-inline--fa {
  bottom: 0;
  left: 0;
  margin: auto;
  position: absolute;
  right: 0;
  top: 0;
}

.fa-layers-counter, .fa-layers-text {
  display: inline-block;
  position: absolute;
  text-align: center;
}

.fa-layers {
  display: inline-block;
  height: 1em;
  position: relative;
  text-align: center;
  vertical-align: -0.125em;
  width: 1em;
}
.fa-layers svg.svg-inline--fa {
  -webkit-transform-origin: center center;
          transform-origin: center center;
}

.fa-layers-text {
  left: 50%;
  top: 50%;
  -webkit-transform: translate(-50%, -50%);
          transform: translate(-50%, -50%);
  -webkit-transform-origin: center center;
          transform-origin: center center;
}

.fa-layers-counter {
  background-color: var(--fa-counter-background-color, #ff253a);
  border-radius: var(--fa-counter-border-radius, 1em);
  box-sizing: border-box;
  color: var(--fa-inverse, #fff);
  line-height: var(--fa-counter-line-height, 1);
  max-width: var(--fa-counter-max-width, 5em);
  min-width: var(--fa-counter-min-width, 1.5em);
  overflow: hidden;
  padding: var(--fa-counter-padding, 0.25em 0.5em);
  right: var(--fa-right, 0);
  text-overflow: ellipsis;
  top: var(--fa-top, 0);
  -webkit-transform: scale(var(--fa-counter-scale, 0.25));
          transform: scale(var(--fa-counter-scale, 0.25));
  -webkit-transform-origin: top right;
          transform-origin: top right;
}

.fa-layers-bottom-right {
  bottom: var(--fa-bottom, 0);
  right: var(--fa-right, 0);
  top: auto;
  -webkit-transform: scale(var(--fa-layers-scale, 0.25));
          transform: scale(var(--fa-layers-scale, 0.25));
  -webkit-transform-origin: bottom right;
          transform-origin: bottom right;
}

.fa-layers-bottom-left {
  bottom: var(--fa-bottom, 0);
  left: var(--fa-left, 0);
  right: auto;
  top: auto;
  -webkit-transform: scale(var(--fa-layers-scale, 0.25));
          transform: scale(var(--fa-layers-scale, 0.25));
  -webkit-transform-origin: bottom left;
          transform-origin: bottom left;
}

.fa-layers-top-right {
  top: var(--fa-top, 0);
  right: var(--fa-right, 0);
  -webkit-transform: scale(var(--fa-layers-scale, 0.25));
          transform: scale(var(--fa-layers-scale, 0.25));
  -webkit-transform-origin: top right;
          transform-origin: top right;
}

.fa-layers-top-left {
  left: var(--fa-left, 0);
  right: auto;
  top: var(--fa-top, 0);
  -webkit-transform: scale(var(--fa-layers-scale, 0.25));
          transform: scale(var(--fa-layers-scale, 0.25));
  -webkit-transform-origin: top left;
          transform-origin: top left;
}

.fa-1x {
  font-size: 1em;
}

.fa-2x {
  font-size: 2em;
}

.fa-3x {
  font-size: 3em;
}

.fa-4x {
  font-size: 4em;
}

.fa-5x {
  font-size: 5em;
}

.fa-6x {
  font-size: 6em;
}

.fa-7x {
  font-size: 7em;
}

.fa-8x {
  font-size: 8em;
}

.fa-9x {
  font-size: 9em;
}

.fa-10x {
  font-size: 10em;
}

.fa-2xs {
  font-size: 0.625em;
  line-height: 0.1em;
  vertical-align: 0.225em;
}

.fa-xs {
  font-size: 0.75em;
  line-height: 0.0833333337em;
  vertical-align: 0.125em;
}

.fa-sm {
  font-size: 0.875em;
  line-height: 0.0714285718em;
  vertical-align: 0.0535714295em;
}

.fa-lg {
  font-size: 1.25em;
  line-height: 0.05em;
  vertical-align: -0.075em;
}

.fa-xl {
  font-size: 1.5em;
  line-height: 0.0416666682em;
  vertical-align: -0.125em;
}

.fa-2xl {
  font-size: 2em;
  line-height: 0.03125em;
  vertical-align: -0.1875em;
}

.fa-fw {
  text-align: center;
  width: 1.25em;
}

.fa-ul {
  list-style-type: none;
  margin-left: var(--fa-li-margin, 2.5em);
  padding-left: 0;
}
.fa-ul > li {
  position: relative;
}

.fa-li {
  left: calc(var(--fa-li-width, 2em) * -1);
  position: absolute;
  text-align: center;
  width: var(--fa-li-width, 2em);
  line-height: inherit;
}

.fa-border {
  border-color: var(--fa-border-color, #eee);
  border-radius: var(--fa-border-radius, 0.1em);
  border-style: var(--fa-border-style, solid);
  border-width: var(--fa-border-width, 0.08em);
  padding: var(--fa-border-padding, 0.2em 0.25em 0.15em);
}

.fa-pull-left {
  float: left;
  margin-right: var(--fa-pull-margin, 0.3em);
}

.fa-pull-right {
  float: right;
  margin-left: var(--fa-pull-margin, 0.3em);
}

.fa-beat {
  -webkit-animation-name: fa-beat;
          animation-name: fa-beat;
  -webkit-animation-delay: var(--fa-animation-delay, 0s);
          animation-delay: var(--fa-animation-delay, 0s);
  -webkit-animation-direction: var(--fa-animation-direction, normal);
          animation-direction: var(--fa-animation-direction, normal);
  -webkit-animation-duration: var(--fa-animation-duration, 1s);
          animation-duration: var(--fa-animation-duration, 1s);
  -webkit-animation-iteration-count: var(--fa-animation-iteration-count, infinite);
          animation-iteration-count: var(--fa-animation-iteration-count, infinite);
  -webkit-animation-timing-function: var(--fa-animation-timing, ease-in-out);
          animation-timing-function: var(--fa-animation-timing, ease-in-out);
}

.fa-bounce {
  -webkit-animation-name: fa-bounce;
          animation-name: fa-bounce;
  -webkit-animation-delay: var(--fa-animation-delay, 0s);
          animation-delay: var(--fa-animation-delay, 0s);
  -webkit-animation-direction: var(--fa-animation-direction, normal);
          animation-direction: var(--fa-animation-direction, normal);
  -webkit-animation-duration: var(--fa-animation-duration, 1s);
          animation-duration: var(--fa-animation-duration, 1s);
  -webkit-animation-iteration-count: var(--fa-animation-iteration-count, infinite);
          animation-iteration-count: var(--fa-animation-iteration-count, infinite);
  -webkit-animation-timing-function: var(--fa-animation-timing, cubic-bezier(0.28, 0.84, 0.42, 1));
          animation-timing-function: var(--fa-animation-timing, cubic-bezier(0.28, 0.84, 0.42, 1));
}

.fa-fade {
  -webkit-animation-name: fa-fade;
          animation-name: fa-fade;
  -webkit-animation-delay: var(--fa-animation-delay, 0s);
          animation-delay: var(--fa-animation-delay, 0s);
  -webkit-animation-direction: var(--fa-animation-direction, normal);
          animation-direction: var(--fa-animation-direction, normal);
  -webkit-animation-duration: var(--fa-animation-duration, 1s);
          animation-duration: var(--fa-animation-duration, 1s);
  -webkit-animation-iteration-count: var(--fa-animation-iteration-count, infinite);
          animation-iteration-count: var(--fa-animation-iteration-count, infinite);
  -webkit-animation-timing-function: var(--fa-animation-timing, cubic-bezier(0.4, 0, 0.6, 1));
          animation-timing-function: var(--fa-animation-timing, cubic-bezier(0.4, 0, 0.6, 1));
}

.fa-beat-fade {
  -webkit-animation-name: fa-beat-fade;
          animation-name: fa-beat-fade;
  -webkit-animation-delay: var(--fa-animation-delay, 0s);
          animation-delay: var(--fa-animation-delay, 0s);
  -webkit-animation-direction: var(--fa-animation-direction, normal);
          animation-direction: var(--fa-animation-direction, normal);
  -webkit-animation-duration: var(--fa-animation-duration, 1s);
          animation-duration: var(--fa-animation-duration, 1s);
  -webkit-animation-iteration-count: var(--fa-animation-iteration-count, infinite);
          animation-iteration-count: var(--fa-animation-iteration-count, infinite);
  -webkit-animation-timing-function: var(--fa-animation-timing, cubic-bezier(0.4, 0, 0.6, 1));
          animation-timing-function: var(--fa-animation-timing, cubic-bezier(0.4, 0, 0.6, 1));
}

.fa-flip {
  -webkit-animation-name: fa-flip;
          animation-name: fa-flip;
  -webkit-animation-delay: var(--fa-animation-delay, 0s);
          animation-delay: var(--fa-animation-delay, 0s);
  -webkit-animation-direction: var(--fa-animation-direction, normal);
          animation-direction: var(--fa-animation-direction, normal);
  -webkit-animation-duration: var(--fa-animation-duration, 1s);
          animation-duration: var(--fa-animation-duration, 1s);
  -webkit-animation-iteration-count: var(--fa-animation-iteration-count, infinite);
          animation-iteration-count: var(--fa-animation-iteration-count, infinite);
  -webkit-animation-timing-function: var(--fa-animation-timing, ease-in-out);
          animation-timing-function: var(--fa-animation-timing, ease-in-out);
}

.fa-shake {
  -webkit-animation-name: fa-shake;
          animation-name: fa-shake;
  -webkit-animation-delay: var(--fa-animation-delay, 0s);
          animation-delay: var(--fa-animation-delay, 0s);
  -webkit-animation-direction: var(--fa-animation-direction, normal);
          animation-direction: var(--fa-animation-direction, normal);
  -webkit-animation-duration: var(--fa-animation-duration, 1s);
          animation-duration: var(--fa-animation-duration, 1s);
  -webkit-animation-iteration-count: var(--fa-animation-iteration-count, infinite);
          animation-iteration-count: var(--fa-animation-iteration-count, infinite);
  -webkit-animation-timing-function: var(--fa-animation-timing, linear);
          animation-timing-function: var(--fa-animation-timing, linear);
}

.fa-spin {
  -webkit-animation-name: fa-spin;
          animation-name: fa-spin;
  -webkit-animation-delay: var(--fa-animation-delay, 0s);
          animation-delay: var(--fa-animation-delay, 0s);
  -webkit-animation-direction: var(--fa-animation-direction, normal);
          animation-direction: var(--fa-animation-direction, normal);
  -webkit-animation-duration: var(--fa-animation-duration, 2s);
          animation-duration: var(--fa-animation-duration, 2s);
  -webkit-animation-iteration-count: var(--fa-animation-iteration-count, infinite);
          animation-iteration-count: var(--fa-animation-iteration-count, infinite);
  -webkit-animation-timing-function: var(--fa-animation-timing, linear);
          animation-timing-function: var(--fa-animation-timing, linear);
}

.fa-spin-reverse {
  --fa-animation-direction: reverse;
}

.fa-pulse,
.fa-spin-pulse {
  -webkit-animation-name: fa-spin;
          animation-name: fa-spin;
  -webkit-animation-direction: var(--fa-animation-direction, normal);
          animation-direction: var(--fa-animation-direction, normal);
  -webkit-animation-duration: var(--fa-animation-duration, 1s);
          animation-duration: var(--fa-animation-duration, 1s);
  -webkit-animation-iteration-count: var(--fa-animation-iteration-count, infinite);
          animation-iteration-count: var(--fa-animation-iteration-count, infinite);
  -webkit-animation-timing-function: var(--fa-animation-timing, steps(8));
          animation-timing-function: var(--fa-animation-timing, steps(8));
}

@media (prefers-reduced-motion: reduce) {
  .fa-beat,
.fa-bounce,
.fa-fade,
.fa-beat-fade,
.fa-flip,
.fa-pulse,
.fa-shake,
.fa-spin,
.fa-spin-pulse {
    -webkit-animation-delay: -1ms;
            animation-delay: -1ms;
    -webkit-animation-duration: 1ms;
            animation-duration: 1ms;
    -webkit-animation-iteration-count: 1;
            animation-iteration-count: 1;
    -webkit-transition-delay: 0s;
            transition-delay: 0s;
    -webkit-transition-duration: 0s;
            transition-duration: 0s;
  }
}
@-webkit-keyframes fa-beat {
  0%, 90% {
    -webkit-transform: scale(1);
            transform: scale(1);
  }
  45% {
    -webkit-transform: scale(var(--fa-beat-scale, 1.25));
            transform: scale(var(--fa-beat-scale, 1.25));
  }
}
@keyframes fa-beat {
  0%, 90% {
    -webkit-transform: scale(1);
            transform: scale(1);
  }
  45% {
    -webkit-transform: scale(var(--fa-beat-scale, 1.25));
            transform: scale(var(--fa-beat-scale, 1.25));
  }
}
@-webkit-keyframes fa-bounce {
  0% {
    -webkit-transform: scale(1, 1) translateY(0);
            transform: scale(1, 1) translateY(0);
  }
  10% {
    -webkit-transform: scale(var(--fa-bounce-start-scale-x, 1.1), var(--fa-bounce-start-scale-y, 0.9)) translateY(0);
            transform: scale(var(--fa-bounce-start-scale-x, 1.1), var(--fa-bounce-start-scale-y, 0.9)) translateY(0);
  }
  30% {
    -webkit-transform: scale(var(--fa-bounce-jump-scale-x, 0.9), var(--fa-bounce-jump-scale-y, 1.1)) translateY(var(--fa-bounce-height, -0.5em));
            transform: scale(var(--fa-bounce-jump-scale-x, 0.9), var(--fa-bounce-jump-scale-y, 1.1)) translateY(var(--fa-bounce-height, -0.5em));
  }
  50% {
    -webkit-transform: scale(var(--fa-bounce-land-scale-x, 1.05), var(--fa-bounce-land-scale-y, 0.95)) translateY(0);
            transform: scale(var(--fa-bounce-land-scale-x, 1.05), var(--fa-bounce-land-scale-y, 0.95)) translateY(0);
  }
  57% {
    -webkit-transform: scale(1, 1) translateY(var(--fa-bounce-rebound, -0.125em));
            transform: scale(1, 1) translateY(var(--fa-bounce-rebound, -0.125em));
  }
  64% {
    -webkit-transform: scale(1, 1) translateY(0);
            transform: scale(1, 1) translateY(0);
  }
  100% {
    -webkit-transform: scale(1, 1) translateY(0);
            transform: scale(1, 1) translateY(0);
  }
}
@keyframes fa-bounce {
  0% {
    -webkit-transform: scale(1, 1) translateY(0);
            transform: scale(1, 1) translateY(0);
  }
  10% {
    -webkit-transform: scale(var(--fa-bounce-start-scale-x, 1.1), var(--fa-bounce-start-scale-y, 0.9)) translateY(0);
            transform: scale(var(--fa-bounce-start-scale-x, 1.1), var(--fa-bounce-start-scale-y, 0.9)) translateY(0);
  }
  30% {
    -webkit-transform: scale(var(--fa-bounce-jump-scale-x, 0.9), var(--fa-bounce-jump-scale-y, 1.1)) translateY(var(--fa-bounce-height, -0.5em));
            transform: scale(var(--fa-bounce-jump-scale-x, 0.9), var(--fa-bounce-jump-scale-y, 1.1)) translateY(var(--fa-bounce-height, -0.5em));
  }
  50% {
    -webkit-transform: scale(var(--fa-bounce-land-scale-x, 1.05), var(--fa-bounce-land-scale-y, 0.95)) translateY(0);
            transform: scale(var(--fa-bounce-land-scale-x, 1.05), var(--fa-bounce-land-scale-y, 0.95)) translateY(0);
  }
  57% {
    -webkit-transform: scale(1, 1) translateY(var(--fa-bounce-rebound, -0.125em));
            transform: scale(1, 1) translateY(var(--fa-bounce-rebound, -0.125em));
  }
  64% {
    -webkit-transform: scale(1, 1) translateY(0);
            transform: scale(1, 1) translateY(0);
  }
  100% {
    -webkit-transform: scale(1, 1) translateY(0);
            transform: scale(1, 1) translateY(0);
  }
}
@-webkit-keyframes fa-fade {
  50% {
    opacity: var(--fa-fade-opacity, 0.4);
  }
}
@keyframes fa-fade {
  50% {
    opacity: var(--fa-fade-opacity, 0.4);
  }
}
@-webkit-keyframes fa-beat-fade {
  0%, 100% {
    opacity: var(--fa-beat-fade-opacity, 0.4);
    -webkit-transform: scale(1);
            transform: scale(1);
  }
  50% {
    opacity: 1;
    -webkit-transform: scale(var(--fa-beat-fade-scale, 1.125));
            transform: scale(var(--fa-beat-fade-scale, 1.125));
  }
}
@keyframes fa-beat-fade {
  0%, 100% {
    opacity: var(--fa-beat-fade-opacity, 0.4);
    -webkit-transform: scale(1);
            transform: scale(1);
  }
  50% {
    opacity: 1;
    -webkit-transform: scale(var(--fa-beat-fade-scale, 1.125));
            transform: scale(var(--fa-beat-fade-scale, 1.125));
  }
}
@-webkit-keyframes fa-flip {
  50% {
    -webkit-transform: rotate3d(var(--fa-flip-x, 0), var(--fa-flip-y, 1), var(--fa-flip-z, 0), var(--fa-flip-angle, -180deg));
            transform: rotate3d(var(--fa-flip-x, 0), var(--fa-flip-y, 1), var(--fa-flip-z, 0), var(--fa-flip-angle, -180deg));
  }
}
@keyframes fa-flip {
  50% {
    -webkit-transform: rotate3d(var(--fa-flip-x, 0), var(--fa-flip-y, 1), var(--fa-flip-z, 0), var(--fa-flip-angle, -180deg));
            transform: rotate3d(var(--fa-flip-x, 0), var(--fa-flip-y, 1), var(--fa-flip-z, 0), var(--fa-flip-angle, -180deg));
  }
}
@-webkit-keyframes fa-shake {
  0% {
    -webkit-transform: rotate(-15deg);
            transform: rotate(-15deg);
  }
  4% {
    -webkit-transform: rotate(15deg);
            transform: rotate(15deg);
  }
  8%, 24% {
    -webkit-transform: rotate(-18deg);
            transform: rotate(-18deg);
  }
  12%, 28% {
    -webkit-transform: rotate(18deg);
            transform: rotate(18deg);
  }
  16% {
    -webkit-transform: rotate(-22deg);
            transform: rotate(-22deg);
  }
  20% {
    -webkit-transform: rotate(22deg);
            transform: rotate(22deg);
  }
  32% {
    -webkit-transform: rotate(-12deg);
            transform: rotate(-12deg);
  }
  36% {
    -webkit-transform: rotate(12deg);
            transform: rotate(12deg);
  }
  40%, 100% {
    -webkit-transform: rotate(0deg);
            transform: rotate(0deg);
  }
}
@keyframes fa-shake {
  0% {
    -webkit-transform: rotate(-15deg);
            transform: rotate(-15deg);
  }
  4% {
    -webkit-transform: rotate(15deg);
            transform: rotate(15deg);
  }
  8%, 24% {
    -webkit-transform: rotate(-18deg);
            transform: rotate(-18deg);
  }
  12%, 28% {
    -webkit-transform: rotate(18deg);
            transform: rotate(18deg);
  }
  16% {
    -webkit-transform: rotate(-22deg);
            transform: rotate(-22deg);
  }
  20% {
    -webkit-transform: rotate(22deg);
            transform: rotate(22deg);
  }
  32% {
    -webkit-transform: rotate(-12deg);
            transform: rotate(-12deg);
  }
  36% {
    -webkit-transform: rotate(12deg);
            transform: rotate(12deg);
  }
  40%, 100% {
    -webkit-transform: rotate(0deg);
            transform: rotate(0deg);
  }
}
@-webkit-keyframes fa-spin {
  0% {
    -webkit-transform: rotate(0deg);
            transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
            transform: rotate(360deg);
  }
}
@keyframes fa-spin {
  0% {
    -webkit-transform: rotate(0deg);
            transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
            transform: rotate(360deg);
  }
}
.fa-rotate-90 {
  -webkit-transform: rotate(90deg);
          transform: rotate(90deg);
}

.fa-rotate-180 {
  -webkit-transform: rotate(180deg);
          transform: rotate(180deg);
}

.fa-rotate-270 {
  -webkit-transform: rotate(270deg);
          transform: rotate(270deg);
}

.fa-flip-horizontal {
  -webkit-transform: scale(-1, 1);
          transform: scale(-1, 1);
}

.fa-flip-vertical {
  -webkit-transform: scale(1, -1);
          transform: scale(1, -1);
}

.fa-flip-both,
.fa-flip-horizontal.fa-flip-vertical {
  -webkit-transform: scale(-1, -1);
          transform: scale(-1, -1);
}

.fa-rotate-by {
  -webkit-transform: rotate(var(--fa-rotate-angle, 0));
          transform: rotate(var(--fa-rotate-angle, 0));
}

.fa-stack {
  display: inline-block;
  vertical-align: middle;
  height: 2em;
  position: relative;
  width: 2.5em;
}

.fa-stack-1x,
.fa-stack-2x {
  bottom: 0;
  left: 0;
  margin: auto;
  position: absolute;
  right: 0;
  top: 0;
  z-index: var(--fa-stack-z-index, auto);
}

.svg-inline--fa.fa-stack-1x {
  height: 1em;
  width: 1.25em;
}
.svg-inline--fa.fa-stack-2x {
  height: 2em;
  width: 2.5em;
}

.fa-inverse {
  color: var(--fa-inverse, #fff);
}

.sr-only,
.fa-sr-only {
  position: absolute;
  width: 1px;
  height: 1px;
  padding: 0;
  margin: -1px;
  overflow: hidden;
  clip: rect(0, 0, 0, 0);
  white-space: nowrap;
  border-width: 0;
}

.sr-only-focusable:not(:focus),
.fa-sr-only-focusable:not(:focus) {
  position: absolute;
  width: 1px;
  height: 1px;
  padding: 0;
  margin: -1px;
  overflow: hidden;
  clip: rect(0, 0, 0, 0);
  white-space: nowrap;
  border-width: 0;
}

.svg-inline--fa .fa-primary {
  fill: var(--fa-primary-color, currentColor);
  opacity: var(--fa-primary-opacity, 1);
}

.svg-inline--fa .fa-secondary {
  fill: var(--fa-secondary-color, currentColor);
  opacity: var(--fa-secondary-opacity, 0.4);
}

.svg-inline--fa.fa-swap-opacity .fa-primary {
  opacity: var(--fa-secondary-opacity, 0.4);
}

.svg-inline--fa.fa-swap-opacity .fa-secondary {
  opacity: var(--fa-primary-opacity, 1);
}

.svg-inline--fa mask .fa-primary,
.svg-inline--fa mask .fa-secondary {
  fill: black;
}

.fad.fa-inverse,
.fa-duotone.fa-inverse {
  color: var(--fa-inverse, #fff);
}`;function qn(){var t=Bn,n=Wn,e=d.cssPrefix,a=d.replacementClass,r=Ze;if(e!==t||a!==n){var o=new RegExp("\\.".concat(t,"\\-"),"g"),s=new RegExp("\\--".concat(t,"\\-"),"g"),f=new RegExp("\\.".concat(n),"g");r=r.replace(o,".".concat(e,"-")).replace(s,"--".concat(e,"-")).replace(f,".".concat(a))}return r}i(qn,"css");var gn=!1;function Tt(){d.autoAddCss&&!gn&&(Xe(qn()),gn=!0)}i(Tt,"ensureCss");var Je={mixout:i(function(){return{dom:{css:qn,insertCss:Tt}}},"mixout"),hooks:i(function(){return{beforeDOMElementCreation:i(function(){Tt()},"beforeDOMElementCreation"),beforeI2svg:i(function(){Tt()},"beforeI2svg")}},"hooks")},F=U||{};F[R]||(F[R]={});F[R].styles||(F[R].styles={});F[R].hooks||(F[R].hooks={});F[R].shims||(F[R].shims=[]);var T=F[R],Qn=[],ta=i(function t(){w.removeEventListener("DOMContentLoaded",t),Ot=1,Qn.map(function(n){return n()})},"listener"),Ot=!1;D&&(Ot=(w.documentElement.doScroll?/^loaded|^c/:/^loaded|^i|^c/).test(w.readyState),Ot||w.addEventListener("DOMContentLoaded",ta));function na(t){D&&(Ot?setTimeout(t,0):Qn.push(t))}i(na,"domready");function ut(t){var n=t.tag,e=t.attributes,a=e===void 0?{}:e,r=t.children,o=r===void 0?[]:r;return typeof t=="string"?Vn(t):"<".concat(n," ").concat(Ve(a),">").concat(o.map(ut).join(""),"</").concat(n,">")}i(ut,"toHtml");function hn(t,n,e){if(t&&t[n]&&t[n][e])return{prefix:n,iconName:e,icon:t[n][e]}}i(hn,"iconFromMapping");var ea=i(function(n,e){return function(a,r,o,s){return n.call(e,a,r,o,s)}},"bindInternal4"),Mt=i(function(n,e,a,r){var o=Object.keys(n),s=o.length,f=r!==void 0?ea(e,r):e,l,u,c;for(a===void 0?(l=1,c=n[o[0]]):(l=0,c=a);l<s;l++)u=o[l],c=f(c,n[u],u,n);return c},"fastReduceObject");function aa(t){for(var n=[],e=0,a=t.length;e<a;){var r=t.charCodeAt(e++);if(r>=55296&&r<=56319&&e<a){var o=t.charCodeAt(e++);(o&64512)==56320?n.push(((r&1023)<<10)+(o&1023)+65536):(n.push(r),e--)}else n.push(r)}return n}i(aa,"ucs2decode");function Yt(t){var n=aa(t);return n.length===1?n[0].toString(16):null}i(Yt,"toHex");function ra(t,n){var e=t.length,a=t.charCodeAt(n),r;return a>=55296&&a<=56319&&e>n+1&&(r=t.charCodeAt(n+1),r>=56320&&r<=57343)?(a-55296)*1024+r-56320+65536:a}i(ra,"codePointAt");function yn(t){return Object.keys(t).reduce(function(n,e){var a=t[e],r=!!a.icon;return r?n[a.iconName]=a.icon:n[e]=a,n},{})}i(yn,"normalizeIcons");function $t(t,n){var e=arguments.length>2&&arguments[2]!==void 0?arguments[2]:{},a=e.skipHooks,r=a===void 0?!1:a,o=yn(n);typeof T.hooks.addPack=="function"&&!r?T.hooks.addPack(t,yn(n)):T.styles[t]=m(m({},T.styles[t]||{}),o),t==="fas"&&$t("fa",n)}i($t,"defineIcons");var ht,yt,kt,q=T.styles,ia=T.shims,oa=(ht={},S(ht,k,Object.values(ot[k])),S(ht,x,Object.values(ot[x])),ht),en=null,Zn={},Jn={},te={},ne={},ee={},sa=(yt={},S(yt,k,Object.keys(rt[k])),S(yt,x,Object.keys(rt[x])),yt);function fa(t){return~Ue.indexOf(t)}i(fa,"isReserved");function la(t,n){var e=n.split("-"),a=e[0],r=e.slice(1).join("-");return a===t&&r!==""&&!fa(r)?r:null}i(la,"getIconName");var ae=i(function(){var n=i(function(o){return Mt(q,function(s,f,l){return s[l]=Mt(f,o,{}),s},{})},"lookup");Zn=n(function(r,o,s){if(o[3]&&(r[o[3]]=s),o[2]){var f=o[2].filter(function(l){return typeof l=="number"});f.forEach(function(l){r[l.toString(16)]=s})}return r}),Jn=n(function(r,o,s){if(r[s]=s,o[2]){var f=o[2].filter(function(l){return typeof l=="string"});f.forEach(function(l){r[l]=s})}return r}),ee=n(function(r,o,s){var f=o[2];return r[s]=s,f.forEach(function(l){r[l]=s}),r});var e="far"in q||d.autoFetchSvg,a=Mt(ia,function(r,o){var s=o[0],f=o[1],l=o[2];return f==="far"&&!e&&(f="fas"),typeof s=="string"&&(r.names[s]={prefix:f,iconName:l}),typeof s=="number"&&(r.unicodes[s.toString(16)]={prefix:f,iconName:l}),r},{names:{},unicodes:{}});te=a.names,ne=a.unicodes,en=Ct(d.styleDefault,{family:d.familyDefault})},"build");Ge(function(t){en=Ct(t.styleDefault,{family:d.familyDefault})});ae();function an(t,n){return(Zn[t]||{})[n]}i(an,"byUnicode");function ca(t,n){return(Jn[t]||{})[n]}i(ca,"byLigature");function G(t,n){return(ee[t]||{})[n]}i(G,"byAlias");function re(t){return te[t]||{prefix:null,iconName:null}}i(re,"byOldName");function ua(t){var n=ne[t],e=an("fas",t);return n||(e?{prefix:"fas",iconName:e}:null)||{prefix:null,iconName:null}}i(ua,"byOldUnicode");function B(){return en}i(B,"getDefaultUsablePrefix");var rn=i(function(){return{prefix:null,iconName:null,rest:[]}},"emptyCanonicalIcon");function Ct(t){var n=arguments.length>1&&arguments[1]!==void 0?arguments[1]:{},e=n.family,a=e===void 0?k:e,r=rt[a][t],o=it[a][t]||it[a][r],s=t in T.styles?t:null;return o||s||null}i(Ct,"getCanonicalPrefix");var kn=(kt={},S(kt,k,Object.keys(ot[k])),S(kt,x,Object.keys(ot[x])),kt);function _t(t){var n,e=arguments.length>1&&arguments[1]!==void 0?arguments[1]:{},a=e.skipLookups,r=a===void 0?!1:a,o=(n={},S(n,k,"".concat(d.cssPrefix,"-").concat(k)),S(n,x,"".concat(d.cssPrefix,"-").concat(x)),n),s=null,f=k;(t.includes(o[k])||t.some(function(u){return kn[k].includes(u)}))&&(f=k),(t.includes(o[x])||t.some(function(u){return kn[x].includes(u)}))&&(f=x);var l=t.reduce(function(u,c){var v=la(d.cssPrefix,c);if(q[c]?(c=oa[f].includes(c)?Re[f][c]:c,s=c,u.prefix=c):sa[f].indexOf(c)>-1?(s=c,u.prefix=Ct(c,{family:f})):v?u.iconName=v:c!==d.replacementClass&&c!==o[k]&&c!==o[x]&&u.rest.push(c),!r&&u.prefix&&u.iconName){var g=s==="fa"?re(u.iconName):{},h=G(u.prefix,u.iconName);g.prefix&&(s=null),u.iconName=g.iconName||h||u.iconName,u.prefix=g.prefix||u.prefix,u.prefix==="far"&&!q.far&&q.fas&&!d.autoFetchSvg&&(u.prefix="fas")}return u},rn());return(t.includes("fa-brands")||t.includes("fab"))&&(l.prefix="fab"),(t.includes("fa-duotone")||t.includes("fad"))&&(l.prefix="fad"),!l.prefix&&f===x&&(q.fass||d.autoFetchSvg)&&(l.prefix="fass",l.iconName=G(l.prefix,l.iconName)||l.iconName),(l.prefix==="fa"||s==="fa")&&(l.prefix=B()||"fas"),l}i(_t,"getCanonicalIcon");var ma=function(){function t(){Oe(this,t),this.definitions={}}return i(t,"Library"),Se(t,[{key:"add",value:i(function(){for(var e=this,a=arguments.length,r=new Array(a),o=0;o<a;o++)r[o]=arguments[o];var s=r.reduce(this._pullDefinitions,{});Object.keys(s).forEach(function(f){e.definitions[f]=m(m({},e.definitions[f]||{}),s[f]),$t(f,s[f]);var l=ot[k][f];l&&$t(l,s[f]),ae()})},"add")},{key:"reset",value:i(function(){this.definitions={}},"reset")},{key:"_pullDefinitions",value:i(function(e,a){var r=a.prefix&&a.iconName&&a.icon?{0:a}:a;return Object.keys(r).map(function(o){var s=r[o],f=s.prefix,l=s.iconName,u=s.icon,c=u[2];e[f]||(e[f]={}),c.length>0&&c.forEach(function(v){typeof v=="string"&&(e[f][v]=u)}),e[f][l]=u}),e},"_pullDefinitions")}]),t}(),wn=[],Q={},Z={},da=Object.keys(Z);function va(t,n){var e=n.mixoutsTo;return wn=t,Q={},Object.keys(Z).forEach(function(a){da.indexOf(a)===-1&&delete Z[a]}),wn.forEach(function(a){var r=a.mixout?a.mixout():{};if(Object.keys(r).forEach(function(s){typeof r[s]=="function"&&(e[s]=r[s]),At(r[s])==="object"&&Object.keys(r[s]).forEach(function(f){e[s]||(e[s]={}),e[s][f]=r[s][f]})}),a.hooks){var o=a.hooks();Object.keys(o).forEach(function(s){Q[s]||(Q[s]=[]),Q[s].push(o[s])})}a.provides&&a.provides(Z)}),e}i(va,"registerPlugins");function Ut(t,n){for(var e=arguments.length,a=new Array(e>2?e-2:0),r=2;r<e;r++)a[r-2]=arguments[r];var o=Q[t]||[];return o.forEach(function(s){n=s.apply(null,[n].concat(a))}),n}i(Ut,"chainHooks");function K(t){for(var n=arguments.length,e=new Array(n>1?n-1:0),a=1;a<n;a++)e[a-1]=arguments[a];var r=Q[t]||[];r.forEach(function(o){o.apply(null,e)})}i(K,"callHooks");function j(){var t=arguments[0],n=Array.prototype.slice.call(arguments,1);return Z[t]?Z[t].apply(null,n):void 0}i(j,"callProvided");function Bt(t){t.prefix==="fa"&&(t.prefix="fas");var n=t.iconName,e=t.prefix||B();if(n)return n=G(e,n)||n,hn(ie.definitions,e,n)||hn(T.styles,e,n)}i(Bt,"findIconDefinition");var ie=new ma,pa=i(function(){d.autoReplaceSvg=!1,d.observeMutations=!1,K("noAuto")},"noAuto"),ba={i2svg:i(function(){var n=arguments.length>0&&arguments[0]!==void 0?arguments[0]:{};return D?(K("beforeI2svg",n),j("pseudoElements2svg",n),j("i2svg",n)):Promise.reject("Operation requires a DOM of some kind.")},"i2svg"),watch:i(function(){var n=arguments.length>0&&arguments[0]!==void 0?arguments[0]:{},e=n.autoReplaceSvgRoot;d.autoReplaceSvg===!1&&(d.autoReplaceSvg=!0),d.observeMutations=!0,na(function(){ha({autoReplaceSvgRoot:e}),K("watch",n)})},"watch")},ga={icon:i(function(n){if(n===null)return null;if(At(n)==="object"&&n.prefix&&n.iconName)return{prefix:n.prefix,iconName:G(n.prefix,n.iconName)||n.iconName};if(Array.isArray(n)&&n.length===2){var e=n[1].indexOf("fa-")===0?n[1].slice(3):n[1],a=Ct(n[0]);return{prefix:a,iconName:G(a,e)||e}}if(typeof n=="string"&&(n.indexOf("".concat(d.cssPrefix,"-"))>-1||n.match(Fe))){var r=_t(n.split(" "),{skipLookups:!0});return{prefix:r.prefix||B(),iconName:G(r.prefix,r.iconName)||r.iconName}}if(typeof n=="string"){var o=B();return{prefix:o,iconName:G(o,n)||n}}},"icon")},I={noAuto:pa,config:d,dom:ba,parse:ga,library:ie,findIconDefinition:Bt,toHtml:ut},ha=i(function(){var n=arguments.length>0&&arguments[0]!==void 0?arguments[0]:{},e=n.autoReplaceSvgRoot,a=e===void 0?w:e;(Object.keys(T.styles).length>0||d.autoFetchSvg)&&D&&d.autoReplaceSvg&&I.dom.i2svg({node:a})},"autoReplace");function It(t,n){return Object.defineProperty(t,"abstract",{get:n}),Object.defineProperty(t,"html",{get:i(function(){return t.abstract.map(function(a){return ut(a)})},"get")}),Object.defineProperty(t,"node",{get:i(function(){if(D){var a=w.createElement("div");return a.innerHTML=t.html,a.children}},"get")}),t}i(It,"domVariants");function ya(t){var n=t.children,e=t.main,a=t.mask,r=t.attributes,o=t.styles,s=t.transform;if(nn(s)&&e.found&&!a.found){var f=e.width,l=e.height,u={x:f/l/2,y:.5};r.style=Et(m(m({},o),{},{"transform-origin":"".concat(u.x+s.x/16,"em ").concat(u.y+s.y/16,"em")}))}return[{tag:"svg",attributes:r,children:n}]}i(ya,"asIcon");function ka(t){var n=t.prefix,e=t.iconName,a=t.children,r=t.attributes,o=t.symbol,s=o===!0?"".concat(n,"-").concat(d.cssPrefix,"-").concat(e):o;return[{tag:"svg",attributes:{style:"display: none;"},children:[{tag:"symbol",attributes:m(m({},r),{},{id:s}),children:a}]}]}i(ka,"asSymbol");function on(t){var n=t.icons,e=n.main,a=n.mask,r=t.prefix,o=t.iconName,s=t.transform,f=t.symbol,l=t.title,u=t.maskId,c=t.titleId,v=t.extra,g=t.watchable,h=g===void 0?!1:g,P=a.found?a:e,E=P.width,C=P.height,p=r==="fak",b=[d.replacementClass,o?"".concat(d.cssPrefix,"-").concat(o):""].filter(function(Y){return v.classes.indexOf(Y)===-1}).filter(function(Y){return Y!==""||!!Y}).concat(v.classes).join(" "),y={children:[],attributes:m(m({},v.attributes),{},{"data-prefix":r,"data-icon":o,class:b,role:v.attributes.role||"img",xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 ".concat(E," ").concat(C)})},A=p&&!~v.classes.indexOf("fa-fw")?{width:"".concat(E/C*16*.0625,"em")}:{};h&&(y.attributes[X]=""),l&&(y.children.push({tag:"title",attributes:{id:y.attributes["aria-labelledby"]||"title-".concat(c||ft())},children:[l]}),delete y.attributes.title);var O=m(m({},y),{},{prefix:r,iconName:o,main:e,mask:a,maskId:u,transform:s,symbol:f,styles:m(m({},A),v.styles)}),M=a.found&&e.found?j("generateAbstractMask",O)||{children:[],attributes:{}}:j("generateAbstractIcon",O)||{children:[],attributes:{}},N=M.children,Nt=M.attributes;return O.children=N,O.attributes=Nt,f?ka(O):ya(O)}i(on,"makeInlineSvgAbstract");function xn(t){var n=t.content,e=t.width,a=t.height,r=t.transform,o=t.title,s=t.extra,f=t.watchable,l=f===void 0?!1:f,u=m(m(m({},s.attributes),o?{title:o}:{}),{},{class:s.classes.join(" ")});l&&(u[X]="");var c=m({},s.styles);nn(r)&&(c.transform=Qe({transform:r,startCentered:!0,width:e,height:a}),c["-webkit-transform"]=c.transform);var v=Et(c);v.length>0&&(u.style=v);var g=[];return g.push({tag:"span",attributes:u,children:[n]}),o&&g.push({tag:"span",attributes:{class:"sr-only"},children:[o]}),g}i(xn,"makeLayersTextAbstract");function wa(t){var n=t.content,e=t.title,a=t.extra,r=m(m(m({},a.attributes),e?{title:e}:{}),{},{class:a.classes.join(" ")}),o=Et(a.styles);o.length>0&&(r.style=o);var s=[];return s.push({tag:"span",attributes:r,children:[n]}),e&&s.push({tag:"span",attributes:{class:"sr-only"},children:[e]}),s}i(wa,"makeLayersCounterAbstract");var zt=T.styles;function Wt(t){var n=t[0],e=t[1],a=t.slice(4),r=Vt(a,1),o=r[0],s=null;return Array.isArray(o)?s={tag:"g",attributes:{class:"".concat(d.cssPrefix,"-").concat(H.GROUP)},children:[{tag:"path",attributes:{class:"".concat(d.cssPrefix,"-").concat(H.SECONDARY),fill:"currentColor",d:o[0]}},{tag:"path",attributes:{class:"".concat(d.cssPrefix,"-").concat(H.PRIMARY),fill:"currentColor",d:o[1]}}]}:s={tag:"path",attributes:{fill:"currentColor",d:o}},{found:!0,width:n,height:e,icon:s}}i(Wt,"asFoundIcon");var xa={found:!1,width:512,height:512};function Aa(t,n){!Hn&&!d.showMissingIcons&&t&&console.error('Icon with name "'.concat(t,'" and prefix "').concat(n,'" is missing.'))}i(Aa,"maybeNotifyMissing");function Ht(t,n){var e=n;return n==="fa"&&d.styleDefault!==null&&(n=B()),new Promise(function(a,r){if(j("missingIconAbstract"),e==="fa"){var o=re(t)||{};t=o.iconName||t,n=o.prefix||n}if(t&&n&&zt[n]&&zt[n][t]){var s=zt[n][t];return a(Wt(s))}Aa(t,n),a(m(m({},xa),{},{icon:d.showMissingIcons&&t?j("missingIconAbstract")||{}:{}}))})}i(Ht,"findIcon");var An=i(function(){},"noop"),Gt=d.measurePerformance&&mt&&mt.mark&&mt.measure?mt:{mark:An,measure:An},nt='FA "6.5.2"',Oa=i(function(n){return Gt.mark("".concat(nt," ").concat(n," begins")),function(){return oe(n)}},"begin"),oe=i(function(n){Gt.mark("".concat(nt," ").concat(n," ends")),Gt.measure("".concat(nt," ").concat(n),"".concat(nt," ").concat(n," begins"),"".concat(nt," ").concat(n," ends"))},"end"),sn={begin:Oa,end:oe},wt=i(function(){},"noop");function On(t){var n=t.getAttribute?t.getAttribute(X):null;return typeof n=="string"}i(On,"isWatched");function Sa(t){var n=t.getAttribute?t.getAttribute(Qt):null,e=t.getAttribute?t.getAttribute(Zt):null;return n&&e}i(Sa,"hasPrefixAndIcon");function Pa(t){return t&&t.classList&&t.classList.contains&&t.classList.contains(d.replacementClass)}i(Pa,"hasBeenReplaced");function Ea(){if(d.autoReplaceSvg===!0)return xt.replace;var t=xt[d.autoReplaceSvg];return t||xt.replace}i(Ea,"getMutator");function Ca(t){return w.createElementNS("http://www.w3.org/2000/svg",t)}i(Ca,"createElementNS");function _a(t){return w.createElement(t)}i(_a,"createElement");function se(t){var n=arguments.length>1&&arguments[1]!==void 0?arguments[1]:{},e=n.ceFn,a=e===void 0?t.tag==="svg"?Ca:_a:e;if(typeof t=="string")return w.createTextNode(t);var r=a(t.tag);Object.keys(t.attributes||[]).forEach(function(s){r.setAttribute(s,t.attributes[s])});var o=t.children||[];return o.forEach(function(s){r.appendChild(se(s,{ceFn:a}))}),r}i(se,"convertSVG");function Ia(t){var n=" ".concat(t.outerHTML," ");return n="".concat(n,"Font Awesome fontawesome.com "),n}i(Ia,"nodeAsComment");var xt={replace:i(function(n){var e=n[0];if(e.parentNode)if(n[1].forEach(function(r){e.parentNode.insertBefore(se(r),e)}),e.getAttribute(X)===null&&d.keepOriginalSource){var a=w.createComment(Ia(e));e.parentNode.replaceChild(a,e)}else e.remove()},"replace"),nest:i(function(n){var e=n[0],a=n[1];if(~tn(e).indexOf(d.replacementClass))return xt.replace(n);var r=new RegExp("".concat(d.cssPrefix,"-.*"));if(delete a[0].attributes.id,a[0].attributes.class){var o=a[0].attributes.class.split(" ").reduce(function(f,l){return l===d.replacementClass||l.match(r)?f.toSvg.push(l):f.toNode.push(l),f},{toNode:[],toSvg:[]});a[0].attributes.class=o.toSvg.join(" "),o.toNode.length===0?e.removeAttribute("class"):e.setAttribute("class",o.toNode.join(" "))}var s=a.map(function(f){return ut(f)}).join(`
`);e.setAttribute(X,""),e.innerHTML=s},"nest")};function Sn(t){t()}i(Sn,"performOperationSync");function fe(t,n){var e=typeof n=="function"?n:wt;if(t.length===0)e();else{var a=Sn;d.mutateApproach===ze&&(a=U.requestAnimationFrame||Sn),a(function(){var r=Ea(),o=sn.begin("mutate");t.map(r),o(),e()})}}i(fe,"perform");var fn=!1;function le(){fn=!0}i(le,"disableObservation");function Xt(){fn=!1}i(Xt,"enableObservation");var St=null;function Pn(t){if(pn&&d.observeMutations){var n=t.treeCallback,e=n===void 0?wt:n,a=t.nodeCallback,r=a===void 0?wt:a,o=t.pseudoElementsCallback,s=o===void 0?wt:o,f=t.observeMutationsRoot,l=f===void 0?w:f;St=new pn(function(u){if(!fn){var c=B();tt(u).forEach(function(v){if(v.type==="childList"&&v.addedNodes.length>0&&!On(v.addedNodes[0])&&(d.searchPseudoElements&&s(v.target),e(v.target)),v.type==="attributes"&&v.target.parentNode&&d.searchPseudoElements&&s(v.target.parentNode),v.type==="attributes"&&On(v.target)&&~$e.indexOf(v.attributeName))if(v.attributeName==="class"&&Sa(v.target)){var g=_t(tn(v.target)),h=g.prefix,P=g.iconName;v.target.setAttribute(Qt,h||c),P&&v.target.setAttribute(Zt,P)}else Pa(v.target)&&r(v.target)})}}),D&&St.observe(l,{childList:!0,attributes:!0,characterData:!0,subtree:!0})}}i(Pn,"observe");function Na(){St&&St.disconnect()}i(Na,"disconnect");function Ta(t){var n=t.getAttribute("style"),e=[];return n&&(e=n.split(";").reduce(function(a,r){var o=r.split(":"),s=o[0],f=o.slice(1);return s&&f.length>0&&(a[s]=f.join(":").trim()),a},{})),e}i(Ta,"styleParser");function Ma(t){var n=t.getAttribute("data-prefix"),e=t.getAttribute("data-icon"),a=t.innerText!==void 0?t.innerText.trim():"",r=_t(tn(t));return r.prefix||(r.prefix=B()),n&&e&&(r.prefix=n,r.iconName=e),r.iconName&&r.prefix||(r.prefix&&a.length>0&&(r.iconName=ca(r.prefix,t.innerText)||an(r.prefix,Yt(t.innerText))),!r.iconName&&d.autoFetchSvg&&t.firstChild&&t.firstChild.nodeType===Node.TEXT_NODE&&(r.iconName=t.firstChild.data)),r}i(Ma,"classParser");function za(t){var n=tt(t.attributes).reduce(function(r,o){return r.name!=="class"&&r.name!=="style"&&(r[o.name]=o.value),r},{}),e=t.getAttribute("title"),a=t.getAttribute("data-fa-title-id");return d.autoA11y&&(e?n["aria-labelledby"]="".concat(d.replacementClass,"-title-").concat(a||ft()):(n["aria-hidden"]="true",n.focusable="false")),n}i(za,"attributesParser");function La(){return{iconName:null,title:null,titleId:null,prefix:null,transform:z,symbol:!1,mask:{iconName:null,prefix:null,rest:[]},maskId:null,extra:{classes:[],styles:{},attributes:{}}}}i(La,"blankMeta");function En(t){var n=arguments.length>1&&arguments[1]!==void 0?arguments[1]:{styleParser:!0},e=Ma(t),a=e.iconName,r=e.prefix,o=e.rest,s=za(t),f=Ut("parseNodeAttributes",{},t),l=n.styleParser?Ta(t):[];return m({iconName:a,title:t.getAttribute("title"),titleId:t.getAttribute("data-fa-title-id"),prefix:r,transform:z,mask:{iconName:null,prefix:null,rest:[]},maskId:null,symbol:!1,extra:{classes:o,styles:l,attributes:s}},f)}i(En,"parseMeta");var Ra=T.styles;function ce(t){var n=d.autoReplaceSvg==="nest"?En(t,{styleParser:!1}):En(t);return~n.extra.classes.indexOf(Gn)?j("generateLayersText",t,n):j("generateSvgReplacementMutation",t,n)}i(ce,"generateMutation");var W=new Set;Jt.map(function(t){W.add("fa-".concat(t))});Object.keys(rt[k]).map(W.add.bind(W));Object.keys(rt[x]).map(W.add.bind(W));W=lt(W);function Cn(t){var n=arguments.length>1&&arguments[1]!==void 0?arguments[1]:null;if(!D)return Promise.resolve();var e=w.documentElement.classList,a=i(function(v){return e.add("".concat(bn,"-").concat(v))},"hclAdd"),r=i(function(v){return e.remove("".concat(bn,"-").concat(v))},"hclRemove"),o=d.autoFetchSvg?W:Jt.map(function(c){return"fa-".concat(c)}).concat(Object.keys(Ra));o.includes("fa")||o.push("fa");var s=[".".concat(Gn,":not([").concat(X,"])")].concat(o.map(function(c){return".".concat(c,":not([").concat(X,"])")})).join(", ");if(s.length===0)return Promise.resolve();var f=[];try{f=tt(t.querySelectorAll(s))}catch{}if(f.length>0)a("pending"),r("complete");else return Promise.resolve();var l=sn.begin("onTree"),u=f.reduce(function(c,v){try{var g=ce(v);g&&c.push(g)}catch(h){Hn||h.name==="MissingIcon"&&console.error(h)}return c},[]);return new Promise(function(c,v){Promise.all(u).then(function(g){fe(g,function(){a("active"),a("complete"),r("pending"),typeof n=="function"&&n(),l(),c()})}).catch(function(g){l(),v(g)})})}i(Cn,"onTree");function Fa(t){var n=arguments.length>1&&arguments[1]!==void 0?arguments[1]:null;ce(t).then(function(e){e&&fe([e],n)})}i(Fa,"onNode");function ja(t){return function(n){var e=arguments.length>1&&arguments[1]!==void 0?arguments[1]:{},a=(n||{}).icon?n:Bt(n||{}),r=e.mask;return r&&(r=(r||{}).icon?r:Bt(r||{})),t(a,m(m({},e),{},{mask:r}))}}i(ja,"resolveIcons");var Da=i(function(n){var e=arguments.length>1&&arguments[1]!==void 0?arguments[1]:{},a=e.transform,r=a===void 0?z:a,o=e.symbol,s=o===void 0?!1:o,f=e.mask,l=f===void 0?null:f,u=e.maskId,c=u===void 0?null:u,v=e.title,g=v===void 0?null:v,h=e.titleId,P=h===void 0?null:h,E=e.classes,C=E===void 0?[]:E,p=e.attributes,b=p===void 0?{}:p,y=e.styles,A=y===void 0?{}:y;if(n){var O=n.prefix,M=n.iconName,N=n.icon;return It(m({type:"icon"},n),function(){return K("beforeDOMElementCreation",{iconDefinition:n,params:e}),d.autoA11y&&(g?b["aria-labelledby"]="".concat(d.replacementClass,"-title-").concat(P||ft()):(b["aria-hidden"]="true",b.focusable="false")),on({icons:{main:Wt(N),mask:l?Wt(l.icon):{found:!1,width:null,height:null,icon:{}}},prefix:O,iconName:M,transform:m(m({},z),r),symbol:s,title:g,maskId:c,titleId:P,extra:{attributes:b,styles:A,classes:C}})})}},"render"),Ya={mixout:i(function(){return{icon:ja(Da)}},"mixout"),hooks:i(function(){return{mutationObserverCallbacks:i(function(e){return e.treeCallback=Cn,e.nodeCallback=Fa,e},"mutationObserverCallbacks")}},"hooks"),provides:i(function(n){n.i2svg=function(e){var a=e.node,r=a===void 0?w:a,o=e.callback,s=o===void 0?function(){}:o;return Cn(r,s)},n.generateSvgReplacementMutation=function(e,a){var r=a.iconName,o=a.title,s=a.titleId,f=a.prefix,l=a.transform,u=a.symbol,c=a.mask,v=a.maskId,g=a.extra;return new Promise(function(h,P){Promise.all([Ht(r,f),c.iconName?Ht(c.iconName,c.prefix):Promise.resolve({found:!1,width:512,height:512,icon:{}})]).then(function(E){var C=Vt(E,2),p=C[0],b=C[1];h([e,on({icons:{main:p,mask:b},prefix:f,iconName:r,transform:l,symbol:u,maskId:v,title:o,titleId:s,extra:g,watchable:!0})])}).catch(P)})},n.generateAbstractIcon=function(e){var a=e.children,r=e.attributes,o=e.main,s=e.transform,f=e.styles,l=Et(f);l.length>0&&(r.style=l);var u;return nn(s)&&(u=j("generateAbstractTransformGrouping",{main:o,transform:s,containerWidth:o.width,iconWidth:o.width})),a.push(u||o.icon),{children:a,attributes:r}}},"provides")},$a={mixout:i(function(){return{layer:i(function(e){var a=arguments.length>1&&arguments[1]!==void 0?arguments[1]:{},r=a.classes,o=r===void 0?[]:r;return It({type:"layer"},function(){K("beforeDOMElementCreation",{assembler:e,params:a});var s=[];return e(function(f){Array.isArray(f)?f.map(function(l){s=s.concat(l.abstract)}):s=s.concat(f.abstract)}),[{tag:"span",attributes:{class:["".concat(d.cssPrefix,"-layers")].concat(lt(o)).join(" ")},children:s}]})},"layer")}},"mixout")},Ua={mixout:i(function(){return{counter:i(function(e){var a=arguments.length>1&&arguments[1]!==void 0?arguments[1]:{},r=a.title,o=r===void 0?null:r,s=a.classes,f=s===void 0?[]:s,l=a.attributes,u=l===void 0?{}:l,c=a.styles,v=c===void 0?{}:c;return It({type:"counter",content:e},function(){return K("beforeDOMElementCreation",{content:e,params:a}),wa({content:e.toString(),title:o,extra:{attributes:u,styles:v,classes:["".concat(d.cssPrefix,"-layers-counter")].concat(lt(f))}})})},"counter")}},"mixout")},Ba={mixout:i(function(){return{text:i(function(e){var a=arguments.length>1&&arguments[1]!==void 0?arguments[1]:{},r=a.transform,o=r===void 0?z:r,s=a.title,f=s===void 0?null:s,l=a.classes,u=l===void 0?[]:l,c=a.attributes,v=c===void 0?{}:c,g=a.styles,h=g===void 0?{}:g;return It({type:"text",content:e},function(){return K("beforeDOMElementCreation",{content:e,params:a}),xn({content:e,transform:m(m({},z),o),title:f,extra:{attributes:v,styles:h,classes:["".concat(d.cssPrefix,"-layers-text")].concat(lt(u))}})})},"text")}},"mixout"),provides:i(function(n){n.generateLayersText=function(e,a){var r=a.title,o=a.transform,s=a.extra,f=null,l=null;if(Un){var u=parseInt(getComputedStyle(e).fontSize,10),c=e.getBoundingClientRect();f=c.width/u,l=c.height/u}return d.autoA11y&&!r&&(s.attributes["aria-hidden"]="true"),Promise.resolve([e,xn({content:e.innerHTML,width:f,height:l,transform:o,title:r,extra:s,watchable:!0})])}},"provides")},Wa=new RegExp('"',"ug"),_n=[1105920,1112319];function Ha(t){var n=t.replace(Wa,""),e=ra(n,0),a=e>=_n[0]&&e<=_n[1],r=n.length===2?n[0]===n[1]:!1;return{value:Yt(r?n[0]:n),isSecondary:a||r}}i(Ha,"hexValueFromContent");function In(t,n){var e="".concat(Me).concat(n.replace(":","-"));return new Promise(function(a,r){if(t.getAttribute(e)!==null)return a();var o=tt(t.children),s=o.filter(function(N){return N.getAttribute(Dt)===n})[0],f=U.getComputedStyle(t,n),l=f.getPropertyValue("font-family").match(je),u=f.getPropertyValue("font-weight"),c=f.getPropertyValue("content");if(s&&!l)return t.removeChild(s),a();if(l&&c!=="none"&&c!==""){var v=f.getPropertyValue("content"),g=~["Sharp"].indexOf(l[2])?x:k,h=~["Solid","Regular","Light","Thin","Duotone","Brands","Kit"].indexOf(l[2])?it[g][l[2].toLowerCase()]:De[g][u],P=Ha(v),E=P.value,C=P.isSecondary,p=l[0].startsWith("FontAwesome"),b=an(h,E),y=b;if(p){var A=ua(E);A.iconName&&A.prefix&&(b=A.iconName,h=A.prefix)}if(b&&!C&&(!s||s.getAttribute(Qt)!==h||s.getAttribute(Zt)!==y)){t.setAttribute(e,y),s&&t.removeChild(s);var O=La(),M=O.extra;M.attributes[Dt]=n,Ht(b,h).then(function(N){var Nt=on(m(m({},O),{},{icons:{main:N,mask:rn()},prefix:h,iconName:y,extra:M,watchable:!0})),Y=w.createElementNS("http://www.w3.org/2000/svg","svg");n==="::before"?t.insertBefore(Y,t.firstChild):t.appendChild(Y),Y.outerHTML=Nt.map(function(ve){return ut(ve)}).join(`
`),t.removeAttribute(e),a()}).catch(r)}else a()}else a()})}i(In,"replaceForPosition");function Ga(t){return Promise.all([In(t,"::before"),In(t,"::after")])}i(Ga,"replace");function Xa(t){return t.parentNode!==document.head&&!~Le.indexOf(t.tagName.toUpperCase())&&!t.getAttribute(Dt)&&(!t.parentNode||t.parentNode.tagName!=="svg")}i(Xa,"processable");function Nn(t){if(D)return new Promise(function(n,e){var a=tt(t.querySelectorAll("*")).filter(Xa).map(Ga),r=sn.begin("searchPseudoElements");le(),Promise.all(a).then(function(){r(),Xt(),n()}).catch(function(){r(),Xt(),e()})})}i(Nn,"searchPseudoElements");var Ka={hooks:i(function(){return{mutationObserverCallbacks:i(function(e){return e.pseudoElementsCallback=Nn,e},"mutationObserverCallbacks")}},"hooks"),provides:i(function(n){n.pseudoElements2svg=function(e){var a=e.node,r=a===void 0?w:a;d.searchPseudoElements&&Nn(r)}},"provides")},Tn=!1,Va={mixout:i(function(){return{dom:{unwatch:i(function(){le(),Tn=!0},"unwatch")}}},"mixout"),hooks:i(function(){return{bootstrap:i(function(){Pn(Ut("mutationObserverCallbacks",{}))},"bootstrap"),noAuto:i(function(){Na()},"noAuto"),watch:i(function(e){var a=e.observeMutationsRoot;Tn?Xt():Pn(Ut("mutationObserverCallbacks",{observeMutationsRoot:a}))},"watch")}},"hooks")},Mn=i(function(n){var e={size:16,x:0,y:0,flipX:!1,flipY:!1,rotate:0};return n.toLowerCase().split(" ").reduce(function(a,r){var o=r.toLowerCase().split("-"),s=o[0],f=o.slice(1).join("-");if(s&&f==="h")return a.flipX=!0,a;if(s&&f==="v")return a.flipY=!0,a;if(f=parseFloat(f),isNaN(f))return a;switch(s){case"grow":a.size=a.size+f;break;case"shrink":a.size=a.size-f;break;case"left":a.x=a.x-f;break;case"right":a.x=a.x+f;break;case"up":a.y=a.y-f;break;case"down":a.y=a.y+f;break;case"rotate":a.rotate=a.rotate+f;break}return a},e)},"parseTransformString"),qa={mixout:i(function(){return{parse:{transform:i(function(e){return Mn(e)},"transform")}}},"mixout"),hooks:i(function(){return{parseNodeAttributes:i(function(e,a){var r=a.getAttribute("data-fa-transform");return r&&(e.transform=Mn(r)),e},"parseNodeAttributes")}},"hooks"),provides:i(function(n){n.generateAbstractTransformGrouping=function(e){var a=e.main,r=e.transform,o=e.containerWidth,s=e.iconWidth,f={transform:"translate(".concat(o/2," 256)")},l="translate(".concat(r.x*32,", ").concat(r.y*32,") "),u="scale(".concat(r.size/16*(r.flipX?-1:1),", ").concat(r.size/16*(r.flipY?-1:1),") "),c="rotate(".concat(r.rotate," 0 0)"),v={transform:"".concat(l," ").concat(u," ").concat(c)},g={transform:"translate(".concat(s/2*-1," -256)")},h={outer:f,inner:v,path:g};return{tag:"g",attributes:m({},h.outer),children:[{tag:"g",attributes:m({},h.inner),children:[{tag:a.icon.tag,children:a.icon.children,attributes:m(m({},a.icon.attributes),h.path)}]}]}}},"provides")},Lt={x:0,y:0,width:"100%",height:"100%"};function zn(t){var n=arguments.length>1&&arguments[1]!==void 0?arguments[1]:!0;return t.attributes&&(t.attributes.fill||n)&&(t.attributes.fill="black"),t}i(zn,"fillBlack");function Qa(t){return t.tag==="g"?t.children:[t]}i(Qa,"deGroup");var Za={hooks:i(function(){return{parseNodeAttributes:i(function(e,a){var r=a.getAttribute("data-fa-mask"),o=r?_t(r.split(" ").map(function(s){return s.trim()})):rn();return o.prefix||(o.prefix=B()),e.mask=o,e.maskId=a.getAttribute("data-fa-mask-id"),e},"parseNodeAttributes")}},"hooks"),provides:i(function(n){n.generateAbstractMask=function(e){var a=e.children,r=e.attributes,o=e.main,s=e.mask,f=e.maskId,l=e.transform,u=o.width,c=o.icon,v=s.width,g=s.icon,h=qe({transform:l,containerWidth:v,iconWidth:u}),P={tag:"rect",attributes:m(m({},Lt),{},{fill:"white"})},E=c.children?{children:c.children.map(zn)}:{},C={tag:"g",attributes:m({},h.inner),children:[zn(m({tag:c.tag,attributes:m(m({},c.attributes),h.path)},E))]},p={tag:"g",attributes:m({},h.outer),children:[C]},b="mask-".concat(f||ft()),y="clip-".concat(f||ft()),A={tag:"mask",attributes:m(m({},Lt),{},{id:b,maskUnits:"userSpaceOnUse",maskContentUnits:"userSpaceOnUse"}),children:[P,p]},O={tag:"defs",children:[{tag:"clipPath",attributes:{id:y},children:Qa(g)},A]};return a.push(O,{tag:"rect",attributes:m({fill:"currentColor","clip-path":"url(#".concat(y,")"),mask:"url(#".concat(b,")")},Lt)}),{children:a,attributes:r}}},"provides")},Ja={provides:i(function(n){var e=!1;U.matchMedia&&(e=U.matchMedia("(prefers-reduced-motion: reduce)").matches),n.missingIconAbstract=function(){var a=[],r={fill:"currentColor"},o={attributeType:"XML",repeatCount:"indefinite",dur:"2s"};a.push({tag:"path",attributes:m(m({},r),{},{d:"M156.5,447.7l-12.6,29.5c-18.7-9.5-35.9-21.2-51.5-34.9l22.7-22.7C127.6,430.5,141.5,440,156.5,447.7z M40.6,272H8.5 c1.4,21.2,5.4,41.7,11.7,61.1L50,321.2C45.1,305.5,41.8,289,40.6,272z M40.6,240c1.4-18.8,5.2-37,11.1-54.1l-29.5-12.6 C14.7,194.3,10,216.7,8.5,240H40.6z M64.3,156.5c7.8-14.9,17.2-28.8,28.1-41.5L69.7,92.3c-13.7,15.6-25.5,32.8-34.9,51.5 L64.3,156.5z M397,419.6c-13.9,12-29.4,22.3-46.1,30.4l11.9,29.8c20.7-9.9,39.8-22.6,56.9-37.6L397,419.6z M115,92.4 c13.9-12,29.4-22.3,46.1-30.4l-11.9-29.8c-20.7,9.9-39.8,22.6-56.8,37.6L115,92.4z M447.7,355.5c-7.8,14.9-17.2,28.8-28.1,41.5 l22.7,22.7c13.7-15.6,25.5-32.9,34.9-51.5L447.7,355.5z M471.4,272c-1.4,18.8-5.2,37-11.1,54.1l29.5,12.6 c7.5-21.1,12.2-43.5,13.6-66.8H471.4z M321.2,462c-15.7,5-32.2,8.2-49.2,9.4v32.1c21.2-1.4,41.7-5.4,61.1-11.7L321.2,462z M240,471.4c-18.8-1.4-37-5.2-54.1-11.1l-12.6,29.5c21.1,7.5,43.5,12.2,66.8,13.6V471.4z M462,190.8c5,15.7,8.2,32.2,9.4,49.2h32.1 c-1.4-21.2-5.4-41.7-11.7-61.1L462,190.8z M92.4,397c-12-13.9-22.3-29.4-30.4-46.1l-29.8,11.9c9.9,20.7,22.6,39.8,37.6,56.9 L92.4,397z M272,40.6c18.8,1.4,36.9,5.2,54.1,11.1l12.6-29.5C317.7,14.7,295.3,10,272,8.5V40.6z M190.8,50 c15.7-5,32.2-8.2,49.2-9.4V8.5c-21.2,1.4-41.7,5.4-61.1,11.7L190.8,50z M442.3,92.3L419.6,115c12,13.9,22.3,29.4,30.5,46.1 l29.8-11.9C470,128.5,457.3,109.4,442.3,92.3z M397,92.4l22.7-22.7c-15.6-13.7-32.8-25.5-51.5-34.9l-12.6,29.5 C370.4,72.1,384.4,81.5,397,92.4z"})});var s=m(m({},o),{},{attributeName:"opacity"}),f={tag:"circle",attributes:m(m({},r),{},{cx:"256",cy:"364",r:"28"}),children:[]};return e||f.children.push({tag:"animate",attributes:m(m({},o),{},{attributeName:"r",values:"28;14;28;28;14;28;"})},{tag:"animate",attributes:m(m({},s),{},{values:"1;0;1;1;0;1;"})}),a.push(f),a.push({tag:"path",attributes:m(m({},r),{},{opacity:"1",d:"M263.7,312h-16c-6.6,0-12-5.4-12-12c0-71,77.4-63.9,77.4-107.8c0-20-17.8-40.2-57.4-40.2c-29.1,0-44.3,9.6-59.2,28.7 c-3.9,5-11.1,6-16.2,2.4l-13.1-9.2c-5.6-3.9-6.9-11.8-2.6-17.2c21.2-27.2,46.4-44.7,91.2-44.7c52.3,0,97.4,29.8,97.4,80.2 c0,67.6-77.4,63.5-77.4,107.8C275.7,306.6,270.3,312,263.7,312z"}),children:e?[]:[{tag:"animate",attributes:m(m({},s),{},{values:"1;0;0;0;0;1;"})}]}),e||a.push({tag:"path",attributes:m(m({},r),{},{opacity:"0",d:"M232.5,134.5l7,168c0.3,6.4,5.6,11.5,12,11.5h9c6.4,0,11.7-5.1,12-11.5l7-168c0.3-6.8-5.2-12.5-12-12.5h-23 C237.7,122,232.2,127.7,232.5,134.5z"}),children:[{tag:"animate",attributes:m(m({},s),{},{values:"0;0;1;1;0;0;"})}]}),{tag:"g",attributes:{class:"missing"},children:a}}},"provides")},tr={hooks:i(function(){return{parseNodeAttributes:i(function(e,a){var r=a.getAttribute("data-fa-symbol"),o=r===null?!1:r===""?!0:r;return e.symbol=o,e},"parseNodeAttributes")}},"hooks")},nr=[Je,Ya,$a,Ua,Ba,Ka,Va,qa,Za,Ja,tr];va(nr,{mixoutsTo:I});I.noAuto;I.config;I.library;I.dom;var Kt=I.parse;I.findIconDefinition;I.toHtml;var er=I.icon;I.layer;I.text;I.counter;function Ln(t,n){var e=Object.keys(t);if(Object.getOwnPropertySymbols){var a=Object.getOwnPropertySymbols(t);n&&(a=a.filter(function(r){return Object.getOwnPropertyDescriptor(t,r).enumerable})),e.push.apply(e,a)}return e}i(Ln,"ownKeys");function L(t){for(var n=1;n<arguments.length;n++){var e=arguments[n]!=null?arguments[n]:{};n%2?Ln(Object(e),!0).forEach(function(a){_(t,a,e[a])}):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(e)):Ln(Object(e)).forEach(function(a){Object.defineProperty(t,a,Object.getOwnPropertyDescriptor(e,a))})}return t}i(L,"_objectSpread2");function ar(t,n){if(typeof t!="object"||!t)return t;var e=t[Symbol.toPrimitive];if(e!==void 0){var a=e.call(t,n||"default");if(typeof a!="object")return a;throw new TypeError("@@toPrimitive must return a primitive value.")}return(n==="string"?String:Number)(t)}i(ar,"_toPrimitive");function rr(t){var n=ar(t,"string");return typeof n=="symbol"?n:n+""}i(rr,"_toPropertyKey");function Pt(t){"@babel/helpers - typeof";return Pt=typeof Symbol=="function"&&typeof Symbol.iterator=="symbol"?function(n){return typeof n}:function(n){return n&&typeof Symbol=="function"&&n.constructor===Symbol&&n!==Symbol.prototype?"symbol":typeof n},Pt(t)}i(Pt,"_typeof");function _(t,n,e){return n=rr(n),n in t?Object.defineProperty(t,n,{value:e,enumerable:!0,configurable:!0,writable:!0}):t[n]=e,t}i(_,"_defineProperty");function ir(t,n){if(t==null)return{};var e={};for(var a in t)if(Object.prototype.hasOwnProperty.call(t,a)){if(n.indexOf(a)>=0)continue;e[a]=t[a]}return e}i(ir,"_objectWithoutPropertiesLoose");function or(t,n){if(t==null)return{};var e=ir(t,n),a,r;if(Object.getOwnPropertySymbols){var o=Object.getOwnPropertySymbols(t);for(r=0;r<o.length;r++)a=o[r],!(n.indexOf(a)>=0)&&Object.prototype.propertyIsEnumerable.call(t,a)&&(e[a]=t[a])}return e}i(or,"_objectWithoutProperties");var sr=typeof globalThis<"u"?globalThis:typeof window<"u"?window:typeof global<"u"?global:typeof self<"u"?self:{},ue={exports:{}};(function(t){(function(n){var e=i(function(p,b,y){if(!u(b)||v(b)||g(b)||h(b)||l(b))return b;var A,O=0,M=0;if(c(b))for(A=[],M=b.length;O<M;O++)A.push(e(p,b[O],y));else{A={};for(var N in b)Object.prototype.hasOwnProperty.call(b,N)&&(A[p(N,y)]=e(p,b[N],y))}return A},"_processKeys"),a=i(function(p,b){b=b||{};var y=b.separator||"_",A=b.split||/(?=[A-Z])/;return p.split(A).join(y)},"separateWords"),r=i(function(p){return P(p)?p:(p=p.replace(/[\-_\s]+(.)?/g,function(b,y){return y?y.toUpperCase():""}),p.substr(0,1).toLowerCase()+p.substr(1))},"camelize"),o=i(function(p){var b=r(p);return b.substr(0,1).toUpperCase()+b.substr(1)},"pascalize"),s=i(function(p,b){return a(p,b).toLowerCase()},"decamelize"),f=Object.prototype.toString,l=i(function(p){return typeof p=="function"},"_isFunction"),u=i(function(p){return p===Object(p)},"_isObject"),c=i(function(p){return f.call(p)=="[object Array]"},"_isArray"),v=i(function(p){return f.call(p)=="[object Date]"},"_isDate"),g=i(function(p){return f.call(p)=="[object RegExp]"},"_isRegExp"),h=i(function(p){return f.call(p)=="[object Boolean]"},"_isBoolean"),P=i(function(p){return p=p-0,p===p},"_isNumerical"),E=i(function(p,b){var y=b&&"process"in b?b.process:b;return typeof y!="function"?p:function(A,O){return y(A,p,O)}},"_processor"),C={camelize:r,decamelize:s,pascalize:o,depascalize:s,camelizeKeys:function(p,b){return e(E(r,b),p)},decamelizeKeys:function(p,b){return e(E(s,b),p,b)},pascalizeKeys:function(p,b){return e(E(o,b),p)},depascalizeKeys:function(){return this.decamelizeKeys.apply(this,arguments)}};t.exports?t.exports=C:n.humps=C})(sr)})(ue);var fr=ue.exports,lr=["class","style"];function cr(t){return t.split(";").map(function(n){return n.trim()}).filter(function(n){return n}).reduce(function(n,e){var a=e.indexOf(":"),r=fr.camelize(e.slice(0,a)),o=e.slice(a+1).trim();return n[r]=o,n},{})}i(cr,"styleToObject");function ur(t){return t.split(/\s+/).reduce(function(n,e){return n[e]=!0,n},{})}i(ur,"classToObject");function me(t){var n=arguments.length>1&&arguments[1]!==void 0?arguments[1]:{},e=arguments.length>2&&arguments[2]!==void 0?arguments[2]:{};if(typeof t=="string")return t;var a=(t.children||[]).map(function(l){return me(l)}),r=Object.keys(t.attributes||{}).reduce(function(l,u){var c=t.attributes[u];switch(u){case"class":l.class=ur(c);break;case"style":l.style=cr(c);break;default:l.attrs[u]=c}return l},{attrs:{},class:{},style:{}});e.class;var o=e.style,s=o===void 0?{}:o,f=or(e,lr);return ge(t.tag,L(L(L({},n),{},{class:r.class,style:L(L({},r.style),s)},r.attrs),f),a)}i(me,"convert");var de=!1;try{de=!0}catch{}function mr(){if(!de&&console&&typeof console.error=="function"){var t;(t=console).error.apply(t,arguments)}}i(mr,"log");function Rt(t,n){return Array.isArray(n)&&n.length>0||!Array.isArray(n)&&n?_({},t,n):{}}i(Rt,"objectWithKey");function dr(t){var n,e=(n={"fa-spin":t.spin,"fa-pulse":t.pulse,"fa-fw":t.fixedWidth,"fa-border":t.border,"fa-li":t.listItem,"fa-inverse":t.inverse,"fa-flip":t.flip===!0,"fa-flip-horizontal":t.flip==="horizontal"||t.flip==="both","fa-flip-vertical":t.flip==="vertical"||t.flip==="both"},_(_(_(_(_(_(_(_(_(_(n,"fa-".concat(t.size),t.size!==null),"fa-rotate-".concat(t.rotation),t.rotation!==null),"fa-pull-".concat(t.pull),t.pull!==null),"fa-swap-opacity",t.swapOpacity),"fa-bounce",t.bounce),"fa-shake",t.shake),"fa-beat",t.beat),"fa-fade",t.fade),"fa-beat-fade",t.beatFade),"fa-flash",t.flash),_(_(n,"fa-spin-pulse",t.spinPulse),"fa-spin-reverse",t.spinReverse));return Object.keys(e).map(function(a){return e[a]?a:null}).filter(function(a){return a})}i(dr,"classList");function Rn(t){if(t&&Pt(t)==="object"&&t.prefix&&t.iconName&&t.icon)return t;if(Kt.icon)return Kt.icon(t);if(t===null)return null;if(Pt(t)==="object"&&t.prefix&&t.iconName)return t;if(Array.isArray(t)&&t.length===2)return{prefix:t[0],iconName:t[1]};if(typeof t=="string")return{prefix:"fas",iconName:t}}i(Rn,"normalizeIconArgs");var vr=Fn({name:"FontAwesomeIcon",props:{border:{type:Boolean,default:!1},fixedWidth:{type:Boolean,default:!1},flip:{type:[Boolean,String],default:!1,validator:i(function(n){return[!0,!1,"horizontal","vertical","both"].indexOf(n)>-1},"validator")},icon:{type:[Object,Array,String],required:!0},mask:{type:[Object,Array,String],default:null},maskId:{type:String,default:null},listItem:{type:Boolean,default:!1},pull:{type:String,default:null,validator:i(function(n){return["right","left"].indexOf(n)>-1},"validator")},pulse:{type:Boolean,default:!1},rotation:{type:[String,Number],default:null,validator:i(function(n){return[90,180,270].indexOf(Number.parseInt(n,10))>-1},"validator")},swapOpacity:{type:Boolean,default:!1},size:{type:String,default:null,validator:i(function(n){return["2xs","xs","sm","lg","xl","2xl","1x","2x","3x","4x","5x","6x","7x","8x","9x","10x"].indexOf(n)>-1},"validator")},spin:{type:Boolean,default:!1},transform:{type:[String,Object],default:null},symbol:{type:[Boolean,String],default:!1},title:{type:String,default:null},titleId:{type:String,default:null},inverse:{type:Boolean,default:!1},bounce:{type:Boolean,default:!1},shake:{type:Boolean,default:!1},beat:{type:Boolean,default:!1},fade:{type:Boolean,default:!1},beatFade:{type:Boolean,default:!1},flash:{type:Boolean,default:!1},spinPulse:{type:Boolean,default:!1},spinReverse:{type:Boolean,default:!1}},setup:i(function(n,e){var a=e.attrs,r=V(function(){return Rn(n.icon)}),o=V(function(){return Rt("classes",dr(n))}),s=V(function(){return Rt("transform",typeof n.transform=="string"?Kt.transform(n.transform):n.transform)}),f=V(function(){return Rt("mask",Rn(n.mask))}),l=V(function(){return er(r.value,L(L(L(L({},o.value),s.value),f.value),{},{symbol:n.symbol,title:n.title,titleId:n.titleId,maskId:n.maskId}))});be(l,function(c){if(!c)return mr("Could not find one or more icon(s)",r.value,f.value)},{immediate:!0});var u=V(function(){return l.value?me(l.value.abstract[0],{},a):null});return function(){return u.value}},"setup")});const pr={class:"flex justify-center items-center gap-12 flex-col mt-12 h-full"},br=xe("span",{class:"text-xl"},"Loading ...",-1),yr=Fn({__name:"LoadingComponent",props:{color:{default:"text-black"}},setup(t){return(n,e)=>(he(),ye("div",pr,[ke(ln(vr),{class:we(["fa-spin  fa-4x",n.color]),icon:ln(Ae)},null,8,["class","icon"]),br]))}});export{yr as _};
