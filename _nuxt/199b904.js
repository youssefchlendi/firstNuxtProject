(window.webpackJsonp=window.webpackJsonp||[]).push([[6],{219:function(t,e,r){"use strict";var n=r(8),o=r(307),c=r.n(o);n.default.use(c.a)},286:function(t,e,r){var content=r(374);content.__esModule&&(content=content.default),"string"==typeof content&&(content=[[t.i,content,""]]),content.locals&&(t.exports=content.locals);(0,r(30).default)("5eecc1df",content,!0,{sourceMap:!1})},310:function(t,e,r){"use strict";var n=r(476),o=r(483),c=r(478),l=r(230),d=r(481),m=r(482),f=r(214),h=r(212),v=r(137),_=r(213),y=r(79),w=r(480),x=r(477),k=r(479),M=r(245),D=(r(81),{name:"DefaultLayout",data:function(){return{clipped:!1,drawer:!1,fixed:!1,items:[{icon:"mdi-apps",title:"Welcome",to:"/"},{icon:"mdi-chart-bubble",title:"Inspire",to:"/inspire"},{icon:"mdi-account-cog",title:"Manage leaders",to:"/Admin/manageLeaders"},{icon:"mdi-account-group",title:"Manage troops",to:"/Admin/manageTroops"},{icon:"mdi-toolbox",title:"manage materiel",to:"/UnitAssignedLeader/materiel-manager/manageMateriel"},{icon:"mdi-file-document",title:"demande materiel",to:"/UnitAssignedLeader/materiel-manager/manageDemandeMateriel"},{icon:"mdi-cash-check",title:"manage members subscription",to:"/UnitAssignedLeader/money-manager/manageMembers"},{icon:"mdi-file-document-check",title:"demande materiel",to:"/DemandeMateriel"},{icon:"mdi-account-cog",title:"Manage members",to:"/UnitLeader/manageMembers"}],miniVariant:!1,right:!0,rightDrawer:!1,title:"Vuetify.js"}}}),L=r(99),component=Object(L.a)(D,(function(){var t=this,e=t._self._c;return e(n.a,{attrs:{dark:""}},[e(x.a,{attrs:{"mini-variant":t.miniVariant,clipped:t.clipped,fixed:"",app:"",right:""},model:{value:t.drawer,callback:function(e){t.drawer=e},expression:"drawer"}},[e(h.a,t._l(t.items,(function(r,i){return e(v.a,{key:i,attrs:{to:r.to,router:"",exact:""}},[e(_.a,[e(f.a,[t._v(t._s(r.icon))])],1),t._v(" "),e(y.a,[e(y.b,{domProps:{textContent:t._s(r.title)}})],1)],1)})),1)],1),t._v(" "),e(o.a,{attrs:{"clipped-right":t.clipped,fixed:"",app:""}},[e(c.a,{on:{click:function(e){e.stopPropagation(),t.drawer=!t.drawer}}}),t._v(" "),e(l.a,{attrs:{icon:""},on:{click:function(e){e.stopPropagation(),t.miniVariant=!t.miniVariant}}},[e(f.a,[t._v("mdi-"+t._s("chevron-".concat(t.miniVariant?"right":"left")))])],1),t._v(" "),e(l.a,{attrs:{icon:""},on:{click:function(e){e.stopPropagation(),t.clipped=!t.clipped}}},[e(f.a,[t._v("mdi-application")])],1),t._v(" "),e(l.a,{attrs:{icon:""},on:{click:function(e){e.stopPropagation(),t.fixed=!t.fixed}}},[e(f.a,[t._v("mdi-minus")])],1),t._v(" "),e(M.a,{domProps:{textContent:t._s(t.title)}}),t._v(" "),e(k.a),t._v(" "),t.$auth.loggedIn?e(l.a,{attrs:{icon:""},on:{click:function(e){return e.stopPropagation(),t.$auth.logout()}}},[e(f.a,[t._v("mdi-logout")])],1):t._e(),t._v(" "),e(l.a,{attrs:{icon:""},on:{click:function(e){e.stopPropagation(),t.rightDrawer=!t.rightDrawer}}},[e(f.a,[t._v("mdi-menu")])],1)],1),t._v(" "),e(w.a,[e(d.a,[e("Nuxt")],1)],1),t._v(" "),e(x.a,{attrs:{right:!t.right,temporary:"",fixed:""},model:{value:t.rightDrawer,callback:function(e){t.rightDrawer=e},expression:"rightDrawer"}},[e(h.a,[e(v.a,{nativeOn:{click:function(e){t.right=!t.right}}},[e(_.a,[e(f.a,{attrs:{light:""}},[t._v("\n            mdi-repeat\n          ")])],1),t._v(" "),e(y.b,[t._v("Switch drawer (click me)")])],1)],1)],1),t._v(" "),e(m.a,{attrs:{absolute:!t.fixed,app:""}},[e("span",[t._v("© "+t._s((new Date).getFullYear()))])])],1)}),[],!1,null,null,null);e.a=component.exports},322:function(t,e,r){r(323),t.exports=r(324)},359:function(t,e,r){"use strict";r.r(e);r(1),r(3),r(56),r(70);e.default=function(t){var e=t.store,r=t.error,n=null;e.state.auth.user.roles.forEach((function(t){t.role.includes("Leader")&&1===t.status&&(n=!0)})),n||r({statusCode:401,message:"لست مخول للدخول لهذه الصفحة"})}},360:function(t,e,r){"use strict";r.r(e),e.default=function(t){var e=t.store,r=t.error;null!==e.state.auth.user.responsability&&"materiel-manager"===e.state.auth.user.responsability||r({statusCode:401,message:"لست مخول للدخول لهذه الصفحة"})}},361:function(t,e,r){"use strict";r.r(e),e.default=function(t){var e=t.store,r=t.error;null!==e.state.auth.user.responsability&&"money-manager"===e.state.auth.user.responsability||r({statusCode:401,message:"لست مخول للدخول لهذه الصفحة"})}},362:function(t,e,r){"use strict";r.r(e);r(1),r(3);e.default=function(t){var e,r=t.store,n=t.error,o=null;null===(e=r.state.auth.user.roles)||void 0===e||e.forEach((function(t){"Super Admin"===t.role&&1===t.status&&(o=!0)})),o||n({statusCode:401,message:"لست مخول للدخول لهذه الصفحة"})}},363:function(t,e,r){"use strict";r.r(e);r(1),r(3);e.default=function(t){var e,r=t.store,n=t.error,o=null;null===(e=r.state.auth.user.roles)||void 0===e||e.forEach((function(t){"Unit Leader"===t.role&&1===t.status&&(o=!0)})),o||n({statusCode:401,message:"لست مخول للدخول لهذه الصفحة"})}},373:function(t,e,r){"use strict";r(286)},374:function(t,e,r){var n=r(29)(!1);n.push([t.i,"h1[data-v-5f2073c8]{font-size:20px}",""]),t.exports=n},440:function(t,e){},441:function(t,e,r){"use strict";r.r(e),r.d(e,"state",(function(){return n}));var n=function(){return{posts:[{id:1,title:"My first post",body:"This is my first post"},{id:2,title:"My second post",body:"This is my second post"}]}}},86:function(t,e,r){"use strict";var n=r(476),o={name:"EmptyLayout",layout:"empty",props:{error:{type:Object,default:null}},data:function(){return{pageNotFound:"404 Not Found",otherError:"An error occurred"}},head:function(){return{title:404===this.error.statusCode?this.pageNotFound:this.otherError}}},c=(r(373),r(99)),component=Object(c.a)(o,(function(){var t=this,e=t._self._c;return e(n.a,{attrs:{dark:""}},[404===t.error.statusCode?e("h1",[t._v("\n    "+t._s(t.pageNotFound)+"\n  ")]):e("h1",[t._v("\n    "+t._s(t.error.message)+"\n  ")]),t._v(" "),e("NuxtLink",{attrs:{to:"/"}},[t._v("\n    Home page\n  ")])],1)}),[],!1,null,"5f2073c8",null);e.a=component.exports}},[[322,33,7,34]]]);