import{d as N,r as z,A as x,b as h,s as E,_ as M,$ as T,h as m,o as Y,k as I,x as O,m as j,q,t as L,n as V}from"./app-9c3275bc.js";const X={"<":"&lt;",">":"&gt;",'"':"&quot;","'":"&#039;","&":"&amp;"};let A=0;var W=o=>o.replace(/[<>"&]/g,n=>X[n]||n),D=o=>o+A++;const f={},F=o=>{const{name:n,paths:i=[],d:a,polygons:e=[],points:v}=o;a&&i.push({d:a}),v&&e.push({points:v}),f[n]=Object.assign({},o,{paths:i,polygons:e}),f[n].minX||(f[n].minX=0),f[n].minY||(f[n].minY=0)},R=(...o)=>{for(const n of o)F(n)},U=N({name:"OhVueIcon",props:{name:{type:String,validator:o=>!o||o in f||(console.warn(`Invalid prop: prop "name" is referring to an unregistered icon "${o}".
Please make sure you have imported this icon before using it.`),!1)},title:String,fill:String,scale:{type:[Number,String],default:1},animation:{validator:o=>["spin","spin-pulse","wrench","ring","pulse","flash","float"].includes(o)},hover:Boolean,flip:{validator:o=>["horizontal","vertical","both"].includes(o)},speed:{validator:o=>o==="fast"||o==="slow"},label:String,inverse:Boolean},setup(o){const n=z([]),i=x({outerScale:1.2,x:null,y:null}),a=x({width:0,height:0}),e=h(()=>{const r=Number(o.scale);return isNaN(r)||r<=0?(console.warn('Invalid prop: prop "scale" should be a number over 0.'),i.outerScale):r*i.outerScale}),v=h(()=>({"ov-icon":!0,"ov-inverse":o.inverse,"ov-flip-horizontal":o.flip==="horizontal","ov-flip-vertical":o.flip==="vertical","ov-flip-both":o.flip==="both","ov-spin":o.animation==="spin","ov-spin-pulse":o.animation==="spin-pulse","ov-wrench":o.animation==="wrench","ov-ring":o.animation==="ring","ov-pulse":o.animation==="pulse","ov-flash":o.animation==="flash","ov-float":o.animation==="float","ov-hover":o.hover,"ov-fast":o.speed==="fast","ov-slow":o.speed==="slow"})),t=h(()=>o.name?f[o.name]:null),k=h(()=>t.value?`${t.value.minX} ${t.value.minY} ${t.value.width} ${t.value.height}`:`0 0 ${g.value} ${w.value}`),d=h(()=>{if(!t.value)return 1;const{width:r,height:s}=t.value;return Math.max(r,s)/16}),g=h(()=>a.width||t.value&&t.value.width/d.value*e.value||0),w=h(()=>a.height||t.value&&t.value.height/d.value*e.value||0),S=h(()=>e.value!==1&&{fontSize:e.value+"em"}),C=h(()=>{if(!t.value||!t.value.raw)return null;const r={};let s=t.value.raw;return s=s.replace(/\s(?:xml:)?id=(["']?)([^"')\s]+)\1/g,(l,y,$)=>{const p=D("vat-");return r[$]=p,` id="${p}"`}),s=s.replace(/#(?:([^'")\s]+)|xpointer\(id\((['"]?)([^')]+)\2\)\))/g,(l,y,$,p)=>{const u=y||p;return u&&r[u]?`#${r[u]}`:l}),s}),B=h(()=>t.value&&t.value.attr?t.value.attr:{}),b=()=>{if(!o.name&&o.name!==null&&n.value.length===0)return void console.warn('Invalid prop: prop "name" is required.');if(t.value)return;let r=0,s=0;n.value.forEach(l=>{l.outerScale=e.value,r=Math.max(r,l.width),s=Math.max(s,l.height)}),a.width=r,a.height=s,n.value.forEach(l=>{l.x=(r-l.width)/2,l.y=(s-l.height)/2})};return E(()=>{b()}),M(()=>{b()}),{...T(i),children:n,icon:t,klass:v,style:S,width:g,height:w,box:k,attribs:B,raw:C}},created(){const o=this.$parent;o&&o.children&&o.children.push(this)},render(){const o=Object.assign({role:this.$attrs.role||(this.label||this.title?"img":null),"aria-label":this.label||null,"aria-hidden":!(this.label||this.title),width:this.width,height:this.height,viewBox:this.box},this.attribs);this.attribs.stroke?o.stroke=this.fill?this.fill:"currentColor":o.fill=this.fill?this.fill:"currentColor",this.x&&(o.x=this.x.toString()),this.y&&(o.y=this.y.toString());let n={class:this.klass,style:this.style};if(n=Object.assign(n,o),this.raw){const e=this.title?`<title>${W(this.title)}</title>${this.raw}`:this.raw;n.innerHTML=e}const i=this.title?[m("title",this.title)]:[],a=(e,v,t)=>m(e,{...v,key:`${e}-${t}`});return m("svg",n,this.raw?void 0:i.concat([this.$slots.default?this.$slots.default():this.icon?[...this.icon.paths.map((e,v)=>a("path",e,v)),...this.icon.polygons.map((e,v)=>a("polygon",e,v))]:[]]))}});function c(o,n){n===void 0&&(n={});var i=n.insertAt;if(o&&typeof document<"u"){var a=document.head||document.getElementsByTagName("head")[0],e=document.createElement("style");e.type="text/css",i==="top"&&a.firstChild?a.insertBefore(e,a.firstChild):a.appendChild(e),e.styleSheet?e.styleSheet.cssText=o:e.appendChild(document.createTextNode(o))}}c(`.ov-icon {
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
`);const H=["disabled"],G={__name:"ButtonComponent",props:{label:String,onClick:Function,disabled:Boolean|null,outline:Boolean|null,small:Boolean|null,autoWidth:Boolean|null,fontLight:Boolean|null,bgClass:{type:String,default:"bg-sky-600"},borderClass:{type:String,default:"border-sky-600"}},setup(o){const n=o,i=h(()=>`relative
    disabled:opacity-30
    disabled:cursor-not-allowed
    rounded-lg
    transition
    ${n.autoWidth?"w-auto":"w-full"}
    ${n.outline?"bg-white":n.bgClass}
    ${n.outline?"border-black":n.borderClass}
    ${n.outline?"text-black":"text-white"}
    ${n.outline?"hover:opacity-60":"hover:opacity-80"}
    ${n.small?"text-sm":"text-md"}
    ${n.small?"py-1":"py-3"}
    ${n.small?"font-light":n.fontLight?"font-normal":"font-semibold"}
    ${n.small?"border-[1px]":"border-2"}`);return(a,e)=>(Y(),I("button",{disabled:o.disabled,onClick:e[0]||(e[0]=(...v)=>o.onClick&&o.onClick(...v)),class:V(i.value)},[a.$slots.icon?O(a.$slots,"icon",{key:0}):j("",!0),q(" "+L(o.label),1)],10,H))}};export{G as _,R as c,U as g};
