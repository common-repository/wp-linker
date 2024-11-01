!function(t){"use strict";var e=function(t){return t},n=function(e){return t.isArray(e)},i=function(t){return!n(t)&&t instanceof Object},r=function(e,n){return t.inArray(n,e)},u=function(t,e){for(var n in t)t.hasOwnProperty(n)&&e(t[n],n,t)},a=function(t){return t[t.length-1]},c=function(t){return Array.prototype.slice.call(t)},o=function(t,e,i){return n(t)?function(t,e){var n=[];return u(t,(function(t,i,r){n.push(e(t,i,r))})),n}(t,e):function(t,e,n){var i={};return u(t,(function(t,r,u){r=n?n(r,t):r,i[r]=e(t,r,u)})),i}(t,e,i)},f=function(t,e,n){return o(t,(function(t,i){return t[e].apply(t,n||[])}))};!function(t){var e=function(t,e){var n,i,a,c=(i={},(n=n||{}).publish=function(t,e){u(i[t],(function(t){t(e)}))},n.subscribe=function(t,e){i[t]=i[t]||[],i[t].push(e)},n.unsubscribe=function(t){u(i,(function(e){var n=r(e,t);-1!==n&&e.splice(n,1)}))},n),o=t.$;return c.getType=function(){throw'implement me (return type. "text", "radio", etc.)'},c.$=function(t){return t?o.find(t):o},c.disable=function(){c.$().prop("disabled",!0),c.publish("isEnabled",!1)},c.enable=function(){c.$().prop("disabled",!1),c.publish("isEnabled",!0)},e.equalTo=function(t,e){return t===e},e.publishChange=function(t,n){var i=c.get();e.equalTo(i,a)||c.publish("change",{e:t,domElement:n}),a=i},c},c=function(t,n){var i=e(t,n);return i.get=function(){return i.$().val()},i.set=function(t){i.$().val(t)},i.clear=function(){i.set("")},n.buildSetter=function(t){return function(e){t.call(i,e)}},i},o=function(t,e){t=n(t)?t:[t],e=n(e)?e:[e];var i=!0;return t.length!==e.length?i=!1:u(t,(function(t){(function(t,e){return-1!==r(t,e)})(e,t)||(i=!1)})),i},s=function(t){var e={},n=c(t,e);return n.getType=function(){return"button"},n.$().on("change",(function(t){e.publishChange(t,this)})),n},p=function(e){var i={},r=c(e,i);return r.getType=function(){return"checkbox"},r.get=function(){var e=[];return r.$().filter(":checked").each((function(){e.push(t(this).val())})),e},r.set=function(e){e=n(e)?e:[e],r.$().each((function(){t(this).prop("checked",!1)})),u(e,(function(t){r.$().filter('[value="'+t+'"]').prop("checked",!0)}))},i.equalTo=o,r.$().change((function(t){i.publishChange(t,this)})),r},l=function(t){var e=k(t,{});return e.getType=function(){return"email"},e},h=function(n){var i={},r=e(n,i);return r.getType=function(){return"file"},r.get=function(){return a(r.$().val().split("\\"))},r.clear=function(){this.$().each((function(){t(this).wrap("<form>").closest("form").get(0).reset(),t(this).unwrap()}))},r.$().change((function(t){i.publishChange(t,this)})),r},d=function(t){var e={},n=c(t,e);return n.getType=function(){return"hidden"},n.$().change((function(t){e.publishChange(t,this)})),n},v=function(n){var i={},r=e(n,i);return r.getType=function(){return"file[multiple]"},r.get=function(){var t,e=r.$().get(0).files||[],n=[];for(t=0;t<(e.length||0);t+=1)n.push(e[t].name);return n},r.clear=function(){this.$().each((function(){t(this).wrap("<form>").closest("form").get(0).reset(),t(this).unwrap()}))},r.$().change((function(t){i.publishChange(t,this)})),r},m=function(t){var e={},i=c(t,e);return i.getType=function(){return"select[multiple]"},i.get=function(){return i.$().val()||[]},i.set=function(t){i.$().val(""===t?[]:n(t)?t:[t])},e.equalTo=o,i.$().change((function(t){e.publishChange(t,this)})),i},g=function(t){var e=k(t,{});return e.getType=function(){return"password"},e},y=function(e){var n={},i=c(e,n);return i.getType=function(){return"radio"},i.get=function(){return i.$().filter(":checked").val()||null},i.set=function(e){e?i.$().filter('[value="'+e+'"]').prop("checked",!0):i.$().each((function(){t(this).prop("checked",!1)}))},i.$().change((function(t){n.publishChange(t,this)})),i},b=function(t){var e={},n=c(t,e);return n.getType=function(){return"range"},n.$().change((function(t){e.publishChange(t,this)})),n},$=function(t){var e={},n=c(t,e);return n.getType=function(){return"select"},n.$().change((function(t){e.publishChange(t,this)})),n},k=function(t){var e={},n=c(t,e);return n.getType=function(){return"text"},n.$().on("change keyup keydown",(function(t){e.publishChange(t,this)})),n},x=function(t){var e={},n=c(t,e);return n.getType=function(){return"textarea"},n.$().on("change keyup keydown",(function(t){e.publishChange(t,this)})),n},T=function(t){var e=k(t,{});return e.getType=function(){return"url"},e},w=function(e){var n={},a=e.$,c=e.constructorOverride||{button:s,text:k,url:T,email:l,password:g,range:b,textarea:x,select:$,"select[multiple]":m,radio:y,checkbox:p,file:h,"file[multiple]":v,hidden:d},o=function(e,r){(i(r)?r:a.find(r)).each((function(){var i=t(this).attr("name");n[i]=c[e]({$:t(this)})}))},f=function(e,o){var f=[],s=i(o)?o:a.find(o);i(o)?n[s.attr("name")]=c[e]({$:s}):(s.each((function(){-1===r(f,t(this).attr("name"))&&f.push(t(this).attr("name"))})),u(f,(function(t){n[t]=c[e]({$:a.find('input[name="'+t+'"]')})})))};return a.is("input, select, textarea")?a.is('input[type="button"], button, input[type="submit"]')?o("button",a):a.is("textarea")?o("textarea",a):a.is('input[type="text"]')||a.is("input")&&!a.attr("type")?o("text",a):a.is('input[type="password"]')?o("password",a):a.is('input[type="email"]')?o("email",a):a.is('input[type="url"]')?o("url",a):a.is('input[type="range"]')?o("range",a):a.is("select")?a.is("[multiple]")?o("select[multiple]",a):o("select",a):a.is('input[type="file"]')?a.is("[multiple]")?o("file[multiple]",a):o("file",a):a.is('input[type="hidden"]')?o("hidden",a):a.is('input[type="radio"]')?f("radio",a):a.is('input[type="checkbox"]')?f("checkbox",a):o("text",a):(o("button",'input[type="button"], button, input[type="submit"]'),o("text",'input[type="text"]'),o("password",'input[type="password"]'),o("email",'input[type="email"]'),o("url",'input[type="url"]'),o("range",'input[type="range"]'),o("textarea","textarea"),o("select","select:not([multiple])"),o("select[multiple]","select[multiple]"),o("file",'input[type="file"]:not([multiple])'),o("file[multiple]",'input[type="file"][multiple]'),o("hidden",'input[type="hidden"]'),f("radio",'input[type="radio"]'),f("checkbox",'input[type="checkbox"]')),n};t.fn.inputVal=function(e){var n=t(this),i=w({$:n});return n.is("input, textarea, select")?void 0===e?i[n.attr("name")].get():(i[n.attr("name")].set(e),n):void 0===e?f(i,"get"):(u(e,(function(t,e){i[e].set(t)})),n)},t.fn.inputOnChange=function(e){var n=t(this),i=w({$:n});return u(i,(function(t){t.subscribe("change",(function(t){e.call(t.domElement,t.e)}))})),n},t.fn.inputDisable=function(){var e=t(this);return f(w({$:e}),"disable"),e},t.fn.inputEnable=function(){var e=t(this);return f(w({$:e}),"enable"),e},t.fn.inputClear=function(){var e=t(this);return f(w({$:e}),"clear"),e}}(jQuery),t.fn.repeaterVal=function(){var e,n,i=function(t){if(1===t.length&&(0===t[0].key.length||1===t[0].key.length&&!t[0].key[0]))return t[0].val;u(t,(function(t){t.head=t.key.shift()}));var e,n=function(){var e={};return u(t,(function(t){e[t.head]||(e[t.head]=[]),e[t.head].push(t)})),e}();return/^[0-9]+$/.test(t[0].head)?(e=[],u(n,(function(t){e.push(i(t))}))):(e={},u(n,(function(t,n){e[n]=i(t)}))),e};return i((e=t(this).inputVal(),n=[],u(e,(function(t,e){var i=[];"undefined"!==e&&(i.push(e.match(/^[^\[]*/)[0]),i=i.concat(o(e.match(/\[[^\]]*\]/g),(function(t){return t.replace(/[\[\]]/g,"")}))),n.push({val:t,key:i}))})),n))},t.fn.repeater=function(i){var r;return i=i||{},t(this).each((function(){var f=t(this),s=i.show||function(){t(this).show()},p=i.hide||function(t){t()},l=f.find("[data-repeater-list]").first(),h=function(e,n){return e.filter((function(){return!n||0===t(this).closest((e=n,i="selector",o(e,(function(t){return t[i]}))).join(",")).length;var e,i}))},d=function(){return h(l.find("[data-repeater-item]"),i.repeaters)},v=l.find("[data-repeater-item]").first().clone().hide(),m=h(h(t(this).find("[data-repeater-item]"),i.repeaters).first().find("[data-repeater-delete]"),i.repeaters);i.isFirstItemUndeletable&&m&&m.remove();var g=function(){var t=l.data("repeater-list");return i.$parent?i.$parent.data("item-name")+"["+t+"]":t},y=function(e){i.repeaters&&e.each((function(){var e=t(this);u(i.repeaters,(function(t){e.find(t.selector).repeater(function(){var t={};return u(c(arguments),(function(e){u(e,(function(e,n){t[n]=e}))})),t}(t,{$parent:e}))}))}))},b=function(t,e,n){t&&u(t,(function(t){n.call(e.find(t.selector)[0],t)}))},$=function(e,n,i){e.each((function(e){var r=t(this);r.data("item-name",n+"["+e+"]"),h(r.find("[name]"),i).each((function(){var u=t(this),c=u.attr("name").match(/\[[^\]]+\]/g),o=c?a(c).replace(/\[|\]/g,""):u.attr("name"),f=n+"["+e+"]["+o+"]"+(u.is(":checkbox")||u.attr("multiple")?"[]":"");u.attr("name",f),b(i,r,(function(i){var r=t(this);$(h(r.find("[data-repeater-item]"),i.repeaters||[]),n+"["+e+"]["+r.find("[data-repeater-list]").first().data("repeater-list")+"]",i.repeaters)}))}))})),l.find("input[name][checked]").removeAttr("checked").prop("checked",!0)};$(d(),g(),i.repeaters),y(d()),i.initEmpty&&d().remove(),i.ready&&i.ready((function(){$(d(),g(),i.repeaters)}));var k,x=(k=function(r,a,c){if(a||i.defaultValues){var f={};h(r.find("[name]"),c).each((function(){var e=t(this).attr("name").match(/\[([^\]]*)(\]|\]\[\])$/)[1];f[e]=t(this).attr("name")})),r.inputVal(o((s=a||i.defaultValues,p=function(t,e){return f[e]},n(s)?(l=[],u(s,(function(t,e,n){p(t,e,n)&&l.push(t)}))):(l={},u(s,(function(t,e,n){p(t,e,n)&&(l[e]=t)}))),l),e,(function(t){return f[t]})))}var s,p,l;b(c,r,(function(e){var n=t(this);h(n.find("[data-repeater-item]"),e.repeaters).each((function(){var i=n.find("[data-repeater-list]").data("repeater-list");if(a&&a[i]){var r=t(this).clone();n.find("[data-repeater-item]").remove(),u(a[i],(function(t){var i=r.clone();k(i,t,e.repeaters||[]),n.find("[data-repeater-list]").append(i)}))}else k(t(this),e.defaultValues,e.repeaters||[])}))}))},function(e,n){l.append(e),$(d(),g(),i.repeaters),e.find("[name]").each((function(){t(this).inputClear()})),k(e,n||i.defaultValues,i.repeaters)}),T=function(t){var e=v.clone();x(e,t),i.repeaters&&y(e),s.call(e.get(0))};r=function(t){d().remove(),u(t,T)},h(f.find("[data-repeater-create]"),i.repeaters).click((function(){T()})),l.on("click","[data-repeater-delete]",(function(){var e=t(this).closest("[data-repeater-item]").get(0);p.call(e,(function(){t(e).remove(),$(d(),g(),i.repeaters)}))}))})),this.setList=r,this}}(jQuery);