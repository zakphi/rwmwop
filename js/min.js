/(trident|msie)/i.test(navigator.userAgent)&&document.getElementById&&window.addEventListener&&window.addEventListener("hashchange",function(){var element,id=location.hash.substring(1);/^[A-z0-9_-]+$/.test(id)&&(element=document.getElementById(id))&&(/^(?:a|select|input|button|textarea)$/i.test(element.tagName)||(element.tabIndex=-1),element.focus())},!1);