import{k as s,a as r,c as i,s as d,f as u,i as c,t as b,n as m}from"./app-1db19119.js";const k=["disabled"],y={__name:"ButtonComponent",props:{label:String,onClick:Function,disabled:Boolean|null,outline:Boolean|null,small:Boolean|null,autoWidth:Boolean|null,fontLight:Boolean|null,circle:Boolean|null,bgClass:{type:String,default:"bg-sky-600 dark:bg-sky-800"},borderClass:{type:String,default:"border-sky-600 dark:border-sky-800"},textClass:{type:String,default:"text-white"},danger:Boolean},setup(e){const l=e,a=s(()=>`relative
    disabled:opacity-30
    disabled:cursor-not-allowed
    transition
    ${l.autoWidth?"w-auto":"w-full"}
    ${l.circle?"rounded-full":"rounded-lg"}
    ${l.outline?"bg-white dark:bg-slate-800":l.bgClass}
    ${l.outline?"border-black dark:border-slate-400":l.borderClass}
    ${l.outline?"text-black dark:text-slate-300":l.textClass}
    ${l.outline?"hover:opacity-60":"hover:opacity-80"}
    ${l.small?"text-sm":"text-md"}
    ${l.small?"py-1":"py-3"}
    ${l.small?"font-light":l.fontLight?"font-normal":"font-semibold"}
    ${l.small?"border":"border-2"}`);return(t,o)=>(r(),i("button",{disabled:e.disabled,onClick:o[0]||(o[0]=(...n)=>e.onClick&&e.onClick(...n)),class:m(a.value)},[t.$slots.icon?d(t.$slots,"icon",{key:0}):u("",!0),c(" "+b(e.label),1)],10,k))}};export{y as _};
