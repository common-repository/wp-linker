function renderTooltip(t){const e=t.dataset.id,n=new Tooltip('<div class="spinner"><div class="double-bounce1"></div><div class="double-bounce2"></div></div>',{effectClass:"slide",stateClass:"not-good",baseClass:"ba_ks__tooltip"});n.position(t).show();let o=new XMLHttpRequest;o.onreadystatechange=function(){if(4===this.readyState&&200===this.status){const t=JSON.parse(this.response);n.content(getTooltipContent(t.post))}},o.open("POST",ajaxAdmin,!0);const s=new FormData;s.append("action","wp_linker_ajax_handler"),s.append("requestParams",e),s.append("requestType","getPost"),o.send(s),t.addEventListener("mouseleave",function(t){n.hide()})}function getTooltipContent(t){let e="";return e+='<div class="tooltipContent">',!1!==t.post_thumbnail&&(e+='<div class="imageHolder">',e+='<img src="'+t.post_thumbnail+'" alt="'+t.post_title+'" />',e+="</div>"),e+='<div class="contentHolder">',e+='<p class="title"><a href="'+t.post_url+'">'+t.post_title+"</a></p>",e+='<p class="postContent">'+t.post_content+"</p>",e+="</div>",e+="</div>"}let ajaxAdmin=wp_linker_ajax.url,loadingGif=wp_linker_ajax.gif;document.addEventListener("DOMContentLoaded",function(){let t=Array.from(document.querySelectorAll("a.tooltip-on"));t.length>0&&t.forEach(function(t){t.addEventListener("mouseenter",function(e){renderTooltip(t)})})});