import{d as s,o as i,f as r,r as d,h as u,i as c,t as b,n as m}from"./app-e0c5bdbd.js";const g=["disabled"],k={__name:"ButtonComponent",props:{label:String,onClick:Function,disabled:Boolean|null,outline:Boolean|null,small:Boolean|null,fontLight:Boolean|null,bgClass:{type:String,default:"bg-sky-600"},borderClass:{type:String,default:"border-sky-600"}},setup(e){const l=e,n=s(()=>`relative
    disabled:opacity-70
    disabled:cursor-not-allowed
    rounded-lg
    transition
    w-full
    ${l.outline?"bg-white":l.bgClass}
    ${l.outline?"border-black":l.borderClass}
    ${l.outline?"text-black":"text-white"}
    ${l.outline?"hover:opacity-60":"hover:opacity-80"}
    ${l.small?"text-sm":"text-md"}
    ${l.small?"py-1":"py-3"}
    ${l.small?"font-light":l.fontLight?"font-normal":"font-semibold"}
    ${l.small?"border-[1px]":"border-2"}`);return(t,o)=>(i(),r("button",{disabled:e.disabled,onClick:o[0]||(o[0]=(...a)=>e.onClick&&e.onClick(...a)),class:m(n.value)},[t.$slots.icon?d(t.$slots,"icon",{key:0}):u("",!0),c(" "+b(e.label),1)],10,g))}};export{k as _};
