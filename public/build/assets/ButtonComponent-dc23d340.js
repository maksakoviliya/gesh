import{k as s,a as r,c as d,s as i,f as u,i as b,t as c,n as k}from"./app-76daffe0.js";const m=["disabled"],y={__name:"ButtonComponent",props:{label:String,onClick:Function,disabled:Boolean|null,outline:Boolean|null,small:Boolean|null,autoWidth:Boolean|null,fontLight:Boolean|null,circle:Boolean|null,bgClass:{type:[String,null],default:"bg-sky-600 dark:bg-sky-800"},borderClass:{type:[String,null],default:"border-sky-600 dark:border-sky-800"},textClass:{type:[String,null],default:"text-white"},danger:Boolean},setup(e){const l=e,a=s(()=>`relative
    disabled:opacity-30
    disabled:cursor-not-allowed
    transition
    ${l.autoWidth?"w-auto":"w-full"}
    ${l.circle?"rounded-full":"rounded-lg"}
    ${l.outline?"bg-white dark:bg-slate-800":l.bgClass??"bg-sky-600 dark:bg-sky-800"}
    ${l.outline?"border-black dark:border-slate-400":l.borderClass??"border-sky-600 dark:border-sky-800"}
    ${l.outline?"text-black dark:text-slate-300":l.textClass}
    ${l.outline?"hover:opacity-60":"hover:opacity-80"}
    ${l.small?"text-sm":"text-md"}
    ${l.small?"py-1":"py-3"}
    ${l.small?"font-light":l.fontLight?"font-normal":"font-semibold"}
    ${l.small?"border":"border-2"}`);return(t,o)=>(r(),d("button",{disabled:e.disabled,onClick:o[0]||(o[0]=(...n)=>e.onClick&&e.onClick(...n)),class:k(a.value)},[t.$slots.icon?i(t.$slots,"icon",{key:0}):u("",!0),b(" "+c(e.label),1)],10,m))}};export{y as _};
