import{a as l,c as o,g as e,t as s,n as r}from"./app-2479d1c6.js";const a={class:"font-semibold"},n={class:"font-light"},u={__name:"Alert",props:{error:Boolean|null,title:String,subtitle:String|null},setup(t){return(i,c)=>(l(),o("div",{class:r(`
		px-6
		py-3
		rounded-xl
        ${t.error?"bg-rose-300":"bg-sky-200"}
    `)},[e("div",a,s(t.title),1),e("div",n,s(t.subtitle),1)],2))}};export{u as _};
