import{p as o,a as n,l as s,w as r,m as d,f as i,i as u,t as c,n as b,x as k}from"./app-cc0db7a9.js";const f={__name:"ButtonComponent",props:{label:String,onClick:Function,disabled:Boolean|null,outline:{type:[Boolean,null]},small:Boolean|null,autoWidth:{type:[Boolean,null]},fontLight:Boolean|null,circle:Boolean|null,bgClass:{type:[String,null],default:"bg-sky-600 dark:bg-sky-800"},href:{type:String,default:null},borderClass:{type:[String,null],default:"border-sky-600 dark:border-sky-800"},textClass:{type:[String,null],default:"text-white"},danger:Boolean},setup(l){const e=l,a=o(()=>`relative
    disabled:opacity-30
    disabled:cursor-not-allowed
    transition
    ${e.autoWidth?"w-auto":"w-full"}
    ${e.circle?"rounded-full":"rounded-lg"}
    ${e.outline?"bg-white dark:bg-slate-800":e.bgClass??"bg-sky-600 dark:bg-sky-800"}
    ${e.outline?"border-black dark:border-slate-400":e.borderClass??"border-sky-600 dark:border-sky-800"}
    ${e.outline?"text-black dark:text-slate-300":e.textClass}
    ${e.outline?"hover:opacity-60":"hover:opacity-80"}
    ${e.small?"text-sm":"text-md"}
    ${e.small?"py-1":"py-3"}
    ${e.small?"font-light":e.fontLight?"font-normal":"font-semibold"}
    ${e.small?"border":"border-2"}`);return(t,m)=>(n(),s(k(l.href?"a":"button"),{href:l.href,disabled:l.disabled,onClick:l.onClick,class:b(a.value)},{default:r(()=>[t.$slots.icon?d(t.$slots,"icon",{key:0}):i("",!0),u(" "+c(l.label),1)]),_:3},8,["href","disabled","onClick","class"]))}};export{f as _};
