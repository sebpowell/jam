function updateCheckboxHiddenInputValue(t){var e=[];$(t).find(".checkbox.selected").each(function(){var t=$(this).attr("data-value");e.push(t)});var i=$(t).find("input");i.val(JSON.stringify(e))}function toggleCheckBox(t){$(t).toggleClass("selected"),updateCheckboxHiddenInputValue($(t).parent())}function setupCheckboxTabbing(){$(".checkbox:not(.disabled)").each(function(){$(this).attr("tabIndex",0)})}function isUndefined(t){return"undefined"==typeof t}function isValid(t,e){return validateData[t](e)}function validate(t,e){var i=$.parseJSON(e);if(isUndefined(i.password)){if(isUndefined(i["int"])&&isUndefined(i.numeric)){if(!isUndefined(i.email)&&isValid("empty",t)&&!isValid("email",t))return i.email}else if(isValid("empty",t)&&!isValid("int",t))return i["int"]}else if(isValid("empty",t)&&!isValid("password",t))return i.password}function clearForm(t){$(t).find("input[type=text]").val(""),$(t).find("select").val("");var e=$(t).find("input[type=file]");return e.replaceWith(e.clone()),t}function updateRadioButtonsHiddenInputValue(t){var e=$(t).find(".selected").first().attr("data-value"),i=$(t).find("input");i.val(e)}function toggleRadioButton(t){$(t).parent().find(".radio-button").removeClass("selected"),$(t).addClass("selected"),updateRadioButtonsHiddenInputValue($(t).parent())}function setupRadioButtonTabbing(){$(".radio-button:not(.disabled)").each(function(){$(this).attr("tabIndex",0)})}$(function(){$(".checkbox-holder").each(function(){updateCheckboxHiddenInputValue(this)}),$(".checkbox:not(.disabled)").click(function(){toggleCheckBox(this)}),$(".checkbox").keypress(function(t){switch(t.keyCode||t.which){case 32:toggleCheckBox(t.target);break;case 13:var e=$(t.target).closest("form");e.submit()}}),setupCheckboxTabbing()});var validateData={empty:function(t){return""!==t&&t!==!1&&null!==t},email:function(t){return/^("([ !\x23-\x5B\x5D-\x7E]*|\\[ -~])+"|[-a-z0-9!#$%&'*+\/=?^_`{|}~]+(\.[-a-z0-9!#$%&'*+\/=?^_`{|}~]+)*)@([0-9a-z\u00C0-\u02FF\u0370-\u1EFF]([-0-9a-z\u00C0-\u02FF\u0370-\u1EFF]{0,61}[0-9a-z\u00C0-\u02FF\u0370-\u1EFF])?\.)+[a-z\u00C0-\u02FF\u0370-\u1EFF][-0-9a-z\u00C0-\u02FF\u0370-\u1EFF]{0,17}[a-z\u00C0-\u02FF\u0370-\u1EFF]$/i.test(t)},"int":function(t){return/^-?[0-9]+$/.test(t)},password:function(t){return/^.*(?=.{6,})(?=.*\d)(?=.*[a-žA-Ž]).*$/.test(t)}};$(document).ready(function(){var t=$(".temporary-alert"),e=t.find(".alert");if(!isUndefined(t.html())&&!isUndefined(e.html())){var i=t.find(".alert").attr("class").split(" "),n="."+i.join("."),a=t.find("p").html();$(n).html(a).addClass("active"),-1==$.inArray("success",i)&&setTimeout(function(){$(n).removeClass("active")},2500)}$("button").click(function(){var t,e=$(this).parent(),i=e.find(":input");return i.each(function(){var e=$(this).attr("data-rule"),i=$(this).attr("required");if("file"===$(this).attr("type")&&!isUndefined(i)&&$(this)[0].files.length<1)return t="Please choose a file.",!1;var n=$(this).val();if(isUndefined(i)){if(!isUndefined(e)&&!isUndefined(validate(n,e)))return t=validate(n,e),!1}else{if(!isValid("empty",n))return t="Please, fill out all required inputs.",!1;if(!isUndefined(e)&&!isUndefined(validate(n,e)))return t=validate(n,e),!1}}),isUndefined(t)?void 0:($(".alert.warning").html(t).addClass("active"),setTimeout(function(){$(".alert.warning").removeClass("active")},2500),!1)})}),$(function(){$(".radio-button-holder").each(function(){updateRadioButtonsHiddenInputValue(this)}),$(".radio-button:not(.disabled)").click(function(){toggleRadioButton(this)}),$(".radio-button").keypress(function(t){switch(t.keyCode||t.which){case 32:toggleRadioButton(t.target);break;case 13:var e=$(t.target).closest("form");e.submit()}}),setupRadioButtonTabbing()}),smoothScroll.init(),$(document).ready(function(){function t(t){$(".modal").toggleClass("is-hidden"),setTimeout(function(){$(".modal").toggleClass("show")},t)}function e(t){$(".modal").toggleClass("show"),setTimeout(function(){$(".modal").toggleClass("is-hidden")},t)}function i(t){var e="#navItem"+t;$("#top-nav li").removeClass("active"),$("#top-nav li"+e).addClass("active")}$("body").removeClass("preload"),$("#ourStory").click(function(){t(50)}),$(".modal, .close-modal").click(function(){e(450)}),$(".modal-content").click(function(t){t.stopPropagation()}),$("#mc-embedded-subscribe-form").submit(function(t){var e=$(this);t&&t.preventDefault(),$.ajax({type:"GET",url:"http://london.us9.list-manage.com/subscribe/post-json?u=7f799244738e8b8558a646378&id=6c81011ad7&c=?",data:e.serialize(),cache:!1,async:!0,dataType:"json",contentType:"application/json; charset=utf-8",error:function(){$(".alert.error").addClass("active").html(data.msg),setTimeout(function(){$(".alert.error").removeClass("active")},2500)},success:function(t){"success"!=t.result?($(".alert.warning").addClass("active").html(t.msg),setTimeout(function(){$(".alert.warning").removeClass("active")},2500)):($(".alert.success").addClass("active").html("Almost done! To confirm your suscription, please click the link in the email we've just sent you."),setTimeout(function(){$(".alert.success").removeClass("active")},2500))}})});var n=function(){var t=$("body").scrollTop();t>100?$("#bookTickets").addClass("active"):$("#bookTickets").removeClass("active")};n();var a=$("#sectionStory").offset().top,o=$("#sectionSpeakers").offset().top,s=$("#sectionTopics").offset().top;$(document).scroll(function(){n();var t=$(this).scrollTop()+80;return t>s?(i("Topics"),!1):t>o?(i("Speakers"),!1):t>a?(i("Story"),!1):void $("#top-nav li").removeClass("active")})});