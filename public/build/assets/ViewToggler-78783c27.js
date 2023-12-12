import{q as g}from"./AppLayout-4291fc2f.js";import{c as u,a0 as d,o as s,i as n,g as i,t as m,n as f,O as y,F as _,k as x,e as p,w as h,z as k,u as v,A as w}from"./app-d61f6bb3.js";const b=["innerHTML"],C={class:"font-medium text-sm"},B={__name:"CategoryBox",props:{category:Array|Object,selected:Boolean},setup(r){const e=r,a=u(()=>`flex
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
    ${e.selected?"text-neutral-800 dark:text-white":"text-neutral-500 dark:text-slate-400"}`),o=d(),l=()=>{const t=o.props.query;t.category=t.category===e.category.slug?null:e.category.slug;const c=g.stringifyUrl({url:"/",query:t},{skipNull:!0});y.visit(c)};return(t,c)=>(s(),n("div",{onClick:l,class:f(a.value)},[i("div",{innerHTML:r.category.icon,class:"w-8"},null,8,b),i("div",C,m(r.category.title),1)],2))}},$={class:"pt-4 flex flex-row items-center justify-between overflow-x-auto"},j={__name:"Categories",props:{categories:Array|null},setup(r){const e=d(),a=u(()=>e.props.query.category??null);return(o,l)=>(s(),n("div",$,[(s(!0),n(_,null,x(r.categories,t=>(s(),p(B,{category:t,selected:t.slug===a.value,key:t.id},null,8,["category","selected"]))),128))]))}},A={__name:"ViewToggler",props:{to:String},setup(r){return(e,a)=>(s(),p(v(w),{href:r.to,class:"fixed left-1/2 -translate-x-1/2 bg-white rounded-full px-4 py-2 bottom-8 shadow-lg hover:scale-110 transition"},{default:h(()=>[k(e.$slots,"default")]),_:3},8,["href"]))}};export{j as _,A as a};
