import{q as g}from"./AppLayout-f8e462ef.js";import{m as i,Q as d,a as s,c as n,g as u,t as m,n as f,O as y,F as x,b as _,j as p,w as h,k,u as v,v as b}from"./app-39a0e7e7.js";const w=["innerHTML"],C={class:"font-medium text-sm"},B={__name:"CategoryBox",props:{category:Array|Object,selected:Boolean},setup(r){const e=r,a=i(()=>`flex
        flex-col
        items-center
        justify-center
        gap-2
        p-3
        border-b-2
        hover:text-neutral-800
        dark:hover:text-slate-300
        transition
        cursor-pointer
        ${e.selected?"border-b-neutral-800":"border-transparent"}
    ${e.selected?"text-neutral-800 dark:text-white":"text-neutral-500 dark:text-slate-400"}`),o=d(),l=()=>{const t=o.props.query;t.category=t.category===e.category.slug?null:e.category.slug;const c=g.stringifyUrl({url:route(route().current()),query:t},{skipNull:!0});y.visit(c)};return(t,c)=>(s(),n("div",{onClick:l,class:f(a.value)},[u("div",{innerHTML:r.category.icon,class:"w-8"},null,8,w),u("div",C,m(r.category.title),1)],2))}},$={class:"pt-4 flex flex-row items-center justify-between overflow-x-auto"},S={__name:"Categories",props:{categories:Array|null},setup(r){const e=d(),a=i(()=>e.props.query.category??null);return(o,l)=>(s(),n("div",$,[(s(!0),n(x,null,_(r.categories,t=>(s(),p(B,{category:t,selected:t.slug===a.value,key:t.id},null,8,["category","selected"]))),128))]))}},L={__name:"ViewToggler",props:{to:String},setup(r){return(e,a)=>(s(),p(v(b),{href:r.to,class:"fixed left-1/2 -translate-x-1/2 bg-white dark:bg-slate-700 dark:text-slate-200 rounded-full px-4 py-2 bottom-10 shadow-lg hover:scale-110 transition z-20"},{default:h(()=>[k(e.$slots,"default")]),_:3},8,["href"]))}};export{S as _,L as a};
