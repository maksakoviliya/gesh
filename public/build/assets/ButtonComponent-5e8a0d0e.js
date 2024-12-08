import{q as n,a as s,l as r,w as d,m as a,i,f as u,t as c,n as b,x as k}from"./app-f9def4a7.js";const f={__name:"ButtonComponent",props:{label:String,onClick:Function,disabled:Boolean|null,outline:{type:[Boolean,null]},small:Boolean|null,autoWidth:{type:[Boolean,null]},fontLight:Boolean|null,circle:Boolean|null,bgClass:{type:[String,null],default:"bg-sky-600 dark:bg-sky-800"},href:{type:String,default:null},borderClass:{type:[String,null],default:"border-sky-600 dark:border-sky-800"},textClass:{type:[String,null],default:"text-white"},danger:Boolean},setup(e){const l=e,o=n(()=>`relative
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
    ${l.small?"border":"border-2"}`);return(t,m)=>(s(),r(k(e.href?"a":"button"),{href:e.href,disabled:e.disabled,onClick:e.onClick,class:b(o.value)},{default:d(()=>[t.$slots.icon?a(t.$slots,"icon",{key:0}):i("",!0),a(t.$slots,"default",{},()=>[u(c(e.label),1)])]),_:3},8,["href","disabled","onClick","class"]))}};export{f as _};
