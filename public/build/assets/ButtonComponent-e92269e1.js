import{d as s,o as i,f as r,r as d,h as c,i as u,t as m,n as b}from"./app-b51ae876.js";const k=["disabled"],p={__name:"ButtonComponent",props:{label:String,onClick:Function,disabled:Boolean|null,outline:Boolean|null,small:Boolean|null},setup(l){const e=l,n=s(()=>`relative
    disabled:opacity-70
    disabled:cursor-not-allowed
    rounded-lg
    transition
    w-full
    ${e.outline?"bg-white":"bg-sky-600"}
    ${e.outline?"border-black":"border-sky-600"}
    ${e.outline?"text-black":"text-white"}
    ${e.outline?"hover:opacity-60":"hover:opacity-80"}
    ${e.small?"text-sm":"text-md"}
    ${e.small?"py-1":"py-3"}
    ${e.small?"font-light":"font-semibold"}
    ${e.small?"border-[1px]":"border-2"}`);return(o,t)=>(i(),r("button",{disabled:l.disabled,onClick:t[0]||(t[0]=(...a)=>l.onClick&&l.onClick(...a)),class:b(n.value)},[o.$slots.icon?d(o.$slots,"icon",{key:0}):c("",!0),u(" "+m(l.label),1)],10,k))}};export{p as _};
