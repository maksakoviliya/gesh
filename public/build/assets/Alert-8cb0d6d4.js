import{o,j as l,i as e,t as s,n as r}from"./app-7a8715db.js";const n={class:"font-semibold"},a={class:"font-light"},u={__name:"Alert",props:{error:Boolean|null,title:String,subtitle:String|null},setup(t){return(i,c)=>(o(),l("div",{class:r(`
		px-6
		py-3
		rounded-xl
        ${t.error?"bg-rose-300":"bg-sky-200"}
    `)},[e("div",n,s(t.title),1),e("div",a,s(t.subtitle),1)],2))}};export{u as _};
