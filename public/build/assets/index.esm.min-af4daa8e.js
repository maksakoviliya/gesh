import{d as z,r as B,P as $,m as h,o as I,I as M,bk as Y,h as m}from"./app-bcc81eb6.js";const E={"<":"&lt;",">":"&gt;",'"':"&quot;","'":"&#039;","&":"&amp;"};let O=0;var T=n=>n.replace(/[<>"&]/g,o=>E[o]||o),j=n=>n+O++;const f={},X=n=>{const{name:o,paths:s=[],d:v,polygons:e=[],points:l}=n;v&&s.push({d:v}),l&&e.push({points:l}),f[o]=Object.assign({},n,{paths:s,polygons:e}),f[o].minX||(f[o].minX=0),f[o].minY||(f[o].minY=0)},P=(...n)=>{for(const o of n)X(o)},A=z({name:"OhVueIcon",props:{name:{type:String,validator:n=>!n||n in f||(console.warn(`Invalid prop: prop "name" is referring to an unregistered icon "${n}".
Please make sure you have imported this icon before using it.`),!1)},title:String,fill:String,scale:{type:[Number,String],default:1},animation:{validator:n=>["spin","spin-pulse","wrench","ring","pulse","flash","float"].includes(n)},hover:Boolean,flip:{validator:n=>["horizontal","vertical","both"].includes(n)},speed:{validator:n=>n==="fast"||n==="slow"},label:String,inverse:Boolean},setup(n){const o=B([]),s=$({outerScale:1.2,x:null,y:null}),v=$({width:0,height:0}),e=h(()=>{const r=Number(n.scale);return isNaN(r)||r<=0?(console.warn('Invalid prop: prop "scale" should be a number over 0.'),s.outerScale):r*s.outerScale}),l=h(()=>({"ov-icon":!0,"ov-inverse":n.inverse,"ov-flip-horizontal":n.flip==="horizontal","ov-flip-vertical":n.flip==="vertical","ov-flip-both":n.flip==="both","ov-spin":n.animation==="spin","ov-spin-pulse":n.animation==="spin-pulse","ov-wrench":n.animation==="wrench","ov-ring":n.animation==="ring","ov-pulse":n.animation==="pulse","ov-flash":n.animation==="flash","ov-float":n.animation==="float","ov-hover":n.hover,"ov-fast":n.speed==="fast","ov-slow":n.speed==="slow"})),t=h(()=>n.name?f[n.name]:null),k=h(()=>t.value?`${t.value.minX} ${t.value.minY} ${t.value.width} ${t.value.height}`:`0 0 ${g.value} ${w.value}`),d=h(()=>{if(!t.value)return 1;const{width:r,height:a}=t.value;return Math.max(r,a)/16}),g=h(()=>v.width||t.value&&t.value.width/d.value*e.value||0),w=h(()=>v.height||t.value&&t.value.height/d.value*e.value||0),S=h(()=>e.value!==1&&{fontSize:e.value+"em"}),C=h(()=>{if(!t.value||!t.value.raw)return null;const r={};let a=t.value.raw;return a=a.replace(/\s(?:xml:)?id=(["']?)([^"')\s]+)\1/g,(i,b,x)=>{const p=j("vat-");return r[x]=p,` id="${p}"`}),a=a.replace(/#(?:([^'")\s]+)|xpointer\(id\((['"]?)([^')]+)\2\)\))/g,(i,b,x,p)=>{const u=b||p;return u&&r[u]?`#${r[u]}`:i}),a}),N=h(()=>t.value&&t.value.attr?t.value.attr:{}),y=()=>{if(!n.name&&n.name!==null&&o.value.length===0)return void console.warn('Invalid prop: prop "name" is required.');if(t.value)return;let r=0,a=0;o.value.forEach(i=>{i.outerScale=e.value,r=Math.max(r,i.width),a=Math.max(a,i.height)}),v.width=r,v.height=a,o.value.forEach(i=>{i.x=(r-i.width)/2,i.y=(a-i.height)/2})};return I(()=>{y()}),M(()=>{y()}),{...Y(s),children:o,icon:t,klass:l,style:S,width:g,height:w,box:k,attribs:N,raw:C}},created(){const n=this.$parent;n&&n.children&&n.children.push(this)},render(){const n=Object.assign({role:this.$attrs.role||(this.label||this.title?"img":null),"aria-label":this.label||null,"aria-hidden":!(this.label||this.title),width:this.width,height:this.height,viewBox:this.box},this.attribs);this.attribs.stroke?n.stroke=this.fill?this.fill:"currentColor":n.fill=this.fill?this.fill:"currentColor",this.x&&(n.x=this.x.toString()),this.y&&(n.y=this.y.toString());let o={class:this.klass,style:this.style};if(o=Object.assign(o,n),this.raw){const e=this.title?`<title>${T(this.title)}</title>${this.raw}`:this.raw;o.innerHTML=e}const s=this.title?[m("title",this.title)]:[],v=(e,l,t)=>m(e,{...l,key:`${e}-${t}`});return m("svg",o,this.raw?void 0:s.concat([this.$slots.default?this.$slots.default():this.icon?[...this.icon.paths.map((e,l)=>v("path",e,l)),...this.icon.polygons.map((e,l)=>v("polygon",e,l))]:[]]))}});function c(n,o){o===void 0&&(o={});var s=o.insertAt;if(n&&typeof document<"u"){var v=document.head||document.getElementsByTagName("head")[0],e=document.createElement("style");e.type="text/css",s==="top"&&v.firstChild?v.insertBefore(e,v.firstChild):v.appendChild(e),e.styleSheet?e.styleSheet.cssText=n:e.appendChild(document.createTextNode(n))}}c(`.ov-icon {
  display: inline-block;
  overflow: visible;
  vertical-align: -0.2em;
}
`);c(`/* ---------------- spin ---------------- */
.ov-spin:not(.ov-hover),
.ov-spin.ov-hover:hover,
.ov-parent.ov-hover:hover > .ov-spin {
  animation: ov-spin 1s linear infinite;
}

.ov-spin:not(.ov-hover).ov-fast,
.ov-spin.ov-hover.ov-fast:hover,
.ov-parent.ov-hover:hover > .ov-spin.ov-fast {
  animation: ov-spin 0.7s linear infinite;
}

.ov-spin:not(.ov-hover).ov-slow,
.ov-spin.ov-hover.ov-slow:hover,
.ov-parent.ov-hover:hover > .ov-spin.ov-slow {
  animation: ov-spin 2s linear infinite;
}

/* ---------------- spin-pulse ---------------- */

.ov-spin-pulse:not(.ov-hover),
.ov-spin-pulse.ov-hover:hover,
.ov-parent.ov-hover:hover > .ov-spin-pulse {
  animation: ov-spin 1s infinite steps(8);
}

.ov-spin-pulse:not(.ov-hover).ov-fast,
.ov-spin-pulse.ov-hover.ov-fast:hover,
.ov-parent.ov-hover:hover > .ov-spin-pulse.ov-fast {
  animation: ov-spin 0.7s infinite steps(8);
}

.ov-spin-pulse:not(.ov-hover).ov-slow,
.ov-spin-pulse.ov-hover.ov-slow:hover,
.ov-parent.ov-hover:hover > .ov-spin-pulse.ov-slow {
  animation: ov-spin 2s infinite steps(8);
}

@keyframes ov-spin {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}

/* ---------------- wrench ---------------- */
.ov-wrench:not(.ov-hover),
.ov-wrench.ov-hover:hover,
.ov-parent.ov-hover:hover > .ov-wrench {
  animation: ov-wrench 2.5s ease infinite;
}

.ov-wrench:not(.ov-hover).ov-fast,
.ov-wrench.ov-hover.ov-fast:hover,
.ov-parent.ov-hover:hover > .ov-wrench.ov-fast {
  animation: ov-wrench 1.2s ease infinite;
}

.ov-wrench:not(.ov-hover).ov-slow,
.ov-wrench.ov-hover.ov-slow:hover,
.ov-parent.ov-hover:hover > .ov-wrench.ov-slow {
  animation: ov-wrench 3.7s ease infinite;
}

@keyframes ov-wrench {
  0% {
    transform: rotate(-12deg);
  }

  8% {
    transform: rotate(12deg);
  }

  10%, 28%, 30%, 48%, 50%, 68% {
    transform: rotate(24deg);
  }

  18%, 20%, 38%, 40%, 58%, 60% {
    transform: rotate(-24deg);
  }

  75%, 100% {
    transform: rotate(0deg);
  }
}

/* ---------------- ring ---------------- */
.ov-ring:not(.ov-hover),
.ov-ring.ov-hover:hover,
.ov-parent.ov-hover:hover > .ov-ring {
  animation: ov-ring 2s ease infinite;
}

.ov-ring:not(.ov-hover).ov-fast,
.ov-ring.ov-hover.ov-fast:hover,
.ov-parent.ov-hover:hover > .ov-ring.ov-fast {
  animation: ov-ring 1s ease infinite;
}

.ov-ring:not(.ov-hover).ov-slow,
.ov-ring.ov-hover.ov-slow:hover,
.ov-parent.ov-hover:hover > .ov-ring.ov-slow {
  animation: ov-ring 3s ease infinite;
}

@keyframes ov-ring {
  0% {
    transform: rotate(-15deg);
  }

  2% {
    transform: rotate(15deg);
  }

  4%, 12% {
    transform: rotate(-18deg);
  }

  6% {
    transform: rotate(18deg);
  }

  8% {
    transform: rotate(-22deg);
  }

  10% {
    transform: rotate(22deg);
  }

  12% {
    transform: rotate(-18deg);
  }

  14% {
    transform: rotate(18deg);
  }

  16% {
    transform: rotate(-12deg);
  }

  18% {
    transform: rotate(12deg);
  }

  20%, 100% {
    transform: rotate(0deg);
  }
}

/* ---------------- pulse ---------------- */
.ov-pulse:not(.ov-hover),
.ov-pulse.ov-hover:hover,
.ov-parent.ov-hover:hover > .ov-pulse {
  animation: ov-pulse 2s linear infinite;
}

.ov-pulse:not(.ov-hover).ov-fast,
.ov-pulse.ov-hover.ov-fast:hover,
.ov-parent.ov-hover:hover > .ov-pulse.ov-fast {
  animation: ov-pulse 1s linear infinite;
}

.ov-pulse:not(.ov-hover).ov-slow,
.ov-pulse.ov-hover.ov-slow:hover,
.ov-parent.ov-hover:hover > .ov-pulse.ov-slow {
  animation: ov-pulse 3s linear infinite;
}

@keyframes ov-pulse {
  0% {
    transform: scale(1.1);
  }

  50% {
    transform: scale(0.8);
  }

  100% {
    transform: scale(1.1);
  }
}

/* ---------------- flash ---------------- */
.ov-flash:not(.ov-hover),
.ov-flash.ov-hover:hover,
.ov-parent.ov-hover:hover > .ov-flash {
  animation: ov-flash 2s ease infinite;
}

.ov-flash:not(.ov-hover).ov-fast,
.ov-flash.ov-hover.ov-fast:hover,
.ov-parent.ov-hover:hover > .ov-flash.ov-fast {
  animation: ov-flash 1s ease infinite;
}

.ov-flash:not(.ov-hover).ov-slow,
.ov-flash.ov-hover.ov-slow:hover,
.ov-parent.ov-hover:hover > .ov-flash.ov-slow {
  animation: ov-flash 3s ease infinite;
}

@keyframes ov-flash {
  0%, 100%, 50%{
    opacity: 1;
  }
  25%, 75%{
    opacity: 0;
  }
}

/* ---------------- float ---------------- */
.ov-float:not(.ov-hover),
.ov-float.ov-hover:hover,
.ov-parent.ov-hover:hover > .ov-float {
  animation: ov-float 2s linear infinite;
}

.ov-float:not(.ov-hover).ov-fast,
.ov-float.ov-hover.ov-fast:hover,
.ov-parent.ov-hover:hover > .ov-float.ov-fast {
  animation: ov-float 1s linear infinite;
}

.ov-float:not(.ov-hover).ov-slow,
.ov-float.ov-hover.ov-slow:hover,
.ov-parent.ov-hover:hover > .ov-float.ov-slow {
  animation: ov-float 3s linear infinite;
}

@keyframes ov-float {
  0%, 100% {
    transform: translateY(-3px);
  }
  50% {
    transform: translateY(3px);
  }
}
`);c(`.ov-flip-horizontal {
  transform: scale(-1, 1);
}

.ov-flip-vertical {
  transform: scale(1, -1);
}

.ov-flip-both {
  transform: scale(-1, -1);
}

.ov-inverse {
  color: #fff;
}
`);export{P as c,A as g};
