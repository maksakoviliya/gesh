import{d as s,o as i,f as r,r as d,h as c,i as u,t as m,n as b}from"./app-26741625.js";const k=["disabled"],f={__name:"ButtonComponent",props:{label:String,onClick:Function,disabled:Boolean|null,outline:Boolean|null,small:Boolean|null,fontLight:Boolean|null},setup(o){const l=o,n=s(()=>`relative
    disabled:opacity-70
    disabled:cursor-not-allowed
    rounded-lg
    transition
    w-full
    ${l.outline?"bg-white":"bg-sky-600"}
    ${l.outline?"border-black":"border-sky-600"}
    ${l.outline?"text-black":"text-white"}
    ${l.outline?"hover:opacity-60":"hover:opacity-80"}
    ${l.small?"text-sm":"text-md"}
    ${l.small?"py-1":"py-3"}
    ${l.small?"font-light":l.fontLight?"font-normal":"font-semibold"}
    ${l.small?"border-[1px]":"border-2"}`);return(e,t)=>(i(),r("button",{disabled:o.disabled,onClick:t[0]||(t[0]=(...a)=>o.onClick&&o.onClick(...a)),class:b(n.value)},[e.$slots.icon?d(e.$slots,"icon",{key:0}):c("",!0),u(" "+m(o.label),1)],10,k))}};export{f as _};
