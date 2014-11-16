function isUndefined(e){return"undefined"==typeof e}function isValid(e,i){return validateData[e](i)}function validate(e,i){var t=$.parseJSON(i);if(isUndefined(t.password)){if(isUndefined(t["int"])&&isUndefined(t.numeric)){if(!isUndefined(t.email)&&isValid("empty",e)&&!isValid("email",e))return t.email}else if(isValid("empty",e)&&!isValid("int",e))return t["int"]}else if(isValid("empty",e)&&!isValid("password",e))return t.password}function clearForm(e){$(e).find("input[type=text]").val(""),$(e).find("select").val("");var i=$(e).find("input[type=file]");return i.replaceWith(i.clone()),e}$(document).on("click",".checkbox",function(){var e=$(this).attr("data-value"),i=$(this).parent().find("input"),t=JSON.parse(i.val());if($(this).hasClass("disabled"))return!1;if($(this).hasClass("selected")){if(-1!==$.inArray(e,t)){var n=t.indexOf(e);t.splice(n,1)}}else-1==$.inArray(e,t)&&t.push(e);$(this).toggleClass("selected"),i.val(JSON.stringify(t))});var validateData={empty:function(e){return""!==e&&e!==!1&&null!==e},email:function(e){return/^("([ !\x23-\x5B\x5D-\x7E]*|\\[ -~])+"|[-a-z0-9!#$%&'*+\/=?^_`{|}~]+(\.[-a-z0-9!#$%&'*+\/=?^_`{|}~]+)*)@([0-9a-z\u00C0-\u02FF\u0370-\u1EFF]([-0-9a-z\u00C0-\u02FF\u0370-\u1EFF]{0,61}[0-9a-z\u00C0-\u02FF\u0370-\u1EFF])?\.)+[a-z\u00C0-\u02FF\u0370-\u1EFF][-0-9a-z\u00C0-\u02FF\u0370-\u1EFF]{0,17}[a-z\u00C0-\u02FF\u0370-\u1EFF]$/i.test(e)},"int":function(e){return/^-?[0-9]+$/.test(e)},password:function(e){return/^.*(?=.{6,})(?=.*\d)(?=.*[a-žA-Ž]).*$/.test(e)}};$(document).ready(function(){$("button").click(function(){var e,i=$(this).parent(),t=$(i).find(".flash-message"),n=i.find(":input");return t.addClass("show"),n.each(function(){var i=$(this).attr("data-rule"),t=$(this).attr("required");if("file"===$(this).attr("type")&&!isUndefined(t)&&$(this)[0].files.length<1)return e="Please choose a file.",!1;var n=$(this).val();if(isUndefined(t)){if(!isUndefined(i)&&!isUndefined(validate(n,i)))return e=validate(n,i),!1}else{if(!isValid("empty",n))return e="Please, fill out all required inputs.",!1;if(!isUndefined(i)&&!isUndefined(validate(n,i)))return e=validate(n,i),!1}}),isUndefined(e)?void t.html(""):(t.html('<div class="alert warning"><p>'+e+"</p></div>"),!1)})}),$(document).ready(function(){$("body").prepend($('<div id="debug-grid" style="height: '+$("body").outerHeight()+'px"></div>')),$("body").dblclick(function(){$("#debug-grid").toggleClass("show")})}),$(document).on("click",".radio-button",function(){var e=$(this).attr("data-value"),i=$(this).parent().find("input");return $(this).hasClass("disabled")?!1:(i.val(""),$(this).parent().find(".radio-button").removeClass("selected"),$(this).addClass("selected"),void i.val(e))}),$(document).ready(function(){$("body").removeClass("preload"),$("#theme-switch").click(function(){$("body").toggleClass("dark");var e=$(this).html();$(this).html("Dark Theme"==e?"Light Theme":"Dark Theme")})});