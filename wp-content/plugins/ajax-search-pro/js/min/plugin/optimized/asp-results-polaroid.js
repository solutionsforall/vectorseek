(function(a){a.fn.extend(window.WPD.ajaxsearchpro.plugin,{showPolaroidResults:function(){this.n("results").addClass("photostack");a(".photostack>nav",this.n("resultsDiv")).remove();let c=a("figure",this.n("resultsDiv"));this.n("resultsDiv").css({display:"block",height:"auto"});this.showResultsBox();if(0<c.length)if(this.n("results").css({height:this.o.prescontainerheight}),1==this.o.highlight&&a("figcaption",this.n("resultsDiv")).highlight(this.n("text").val().split(" "),{element:"span",className:"highlighted",
wordsOnly:this.o.highlightWholewords}),"undefined"!==typeof Photostack)this.ptstack=new Photostack(this.n("results").get(0),{callback:function(b){}});else return!1;0==c.length&&(this.n("results").css({height:"11110px"}),this.n("results").css({height:"auto"}));this.addAnimation();this.fixResultsPosition(!0);this.searching=!1;this.initPolaroidEvents(c)},initPolaroidEvents:function(c){let b=this,e=1;c.each(function(){1<e&&a(this).removeClass("photostack-current");a(this).attr("idx",e);e++});c.on("click",
function(d){a(this).hasClass("photostack-current")||(d.preventDefault(),d=a(this).attr("idx"),a(".photostack>nav span:nth-child("+d+")",b.n("resultsDiv")).trigger("click",[],!0))});c.on("mousewheel",function(d){d.preventDefault();1<=(0<d.deltaY?1:-1)?0<a(".photostack>nav span.current",b.n("resultsDiv")).next().length?a(".photostack>nav span.current",b.n("resultsDiv")).next().trigger("click",[],!0):a(".photostack>nav span:nth-child(1)",b.n("resultsDiv")).trigger("click",[],!0):0<a(".photostack>nav span.current",
b.n("resultsDiv")).prev().length?a(".photostack>nav span.current",b.n("resultsDiv")).prev().trigger("click",[],!0):a(".photostack>nav span:nth-last-child(1)",b.n("resultsDiv")).trigger("click",[],!0)});b.n("resultsDiv").on("swiped-left",function(){0<a(".photostack>nav span.current",b.n("resultsDiv")).next().length?a(".photostack>nav span.current",b.n("resultsDiv")).next().trigger("click",[],!0):a(".photostack>nav span:nth-child(1)",b.n("resultsDiv")).trigger("click",[],!0)});b.n("resultsDiv").on("swiped-right",
function(){0<a(".photostack>nav span.current",b.n("resultsDiv")).prev().length?a(".photostack>nav span.current",b.n("resultsDiv")).prev().trigger("click",[],!0):a(".photostack>nav span:nth-last-child(1)",b.n("resultsDiv")).trigger("click",[],!0)})}})})(WPD.dom);
