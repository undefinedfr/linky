var $=jQuery;$(document).ready(function(){$(".js-toggle-menu").click(function(){$(this).closest(".header__burger").toggleClass("is-open"),$(".linky-page").toggleClass("menu-open")})}),$(window).load(function(){$("img").each(function(){var a=$(this),b=a.data(),c=Object.keys(b);if(c.length>0)for(var d=0;d<c.length;d++)c[d].toLowerCase().indexOf("src")>=0&&a.attr("src",a.data(c[d]))})});