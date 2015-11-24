/*
v1.0.1 jQuery baigoSubmit plugin 表单全选插件
(c) 2013 baigo studio - http://www.baigo.net/
License: http://www.opensource.org/licenses/mit-license.php
*/

(function($){
	$.fn.baigoSubmit = function(options) {

		if(this.length == 0) {
			return this;
		}

		// support mutltiple elements
		if(this.length > 1){
			this.each(function(){
				$(this).baigoSubmit(options);
			});
			return this;
		}

    	var thisForm = $(this); //定义表单对象
		var el = this;

		var defaults = {
			width: 350,
			height: 220,
			class_ok: "baigoSubmit_y",
			class_err: "baigoSubmit_x",
			class_loading: "baigoSubmit_loading",
			text_submitting: "Submitting ...",
			btn_url: "",
			btn_text: "OK",
			btn_close: "Close"
		};

		var opts = $.extend(defaults, options);

		//调用弹出框
		var callModal = function() {
			$("body .modal.baigoSubmit_box").modal("show")
		}

        var _is_modal = true;

		if (typeof opts.msg_box == "undefined") {
            var obj_box = $("body .modal.baigoSubmit_box");
    		if (obj_box.length <= 0) {
        		$("body").append("<div class=\"modal fade baigoSubmit_box\">" +
        			"<div class=\"modal-dialog\">" +
        				 "<div class=\"modal-content\">" +
        					"<div class=\"modal-body\">" +
        						"<h4 class=\"box_msg\"></h4>" +
        						"<div class=\"box_alert\"></div>" +
        					"</div>" +
        					"<div class=\"modal-footer\">" +
        						"<a href=\"" + opts.btn_url + "\" class=\"btn btn-primary btn_jump\" target=\"_top\">" + opts.btn_text + "</a>" +
        						"<button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\">" + opts.btn_close + "</button>" +
        					"</li>" +
        				"</div>" +
        			"</div>" +
        		"</div>");
    		}
		} else {
            var obj_box = $(opts.msg_box + " .baigoSubmit_box");

            if (obj_box.length <= 0) {
                $(opts.msg_box).append("<div class=\"baigoSubmit_box\"></div>");
            }

            _is_modal = false;
		}

		//确认消息
		var formConfirm = function() {
			if (typeof opts.confirm_selector == "undefined") {
				return true;
			} else {
				var _form_action = $(opts.confirm_selector).val();
				if (_form_action == opts.confirm_val) {
					if (confirm(opts.confirm_msg)) {
						return true;
					} else {
						return false;
					}
				} else {
					return true;
				}
			}
		}

		//ajax提交
		el.formSubmit = function(_btn_submit) {
			if (formConfirm()) {
    			//boxAppend();
				$.ajax({
					url: opts.ajax_url, //url
					//async: false, //设置为同步
					type: "post",
					dataType: "json", //数据格式为json
					data: $(thisForm).serialize(),
					beforeSend: function(){
						if (_is_modal) {
    						$("body .modal.baigoSubmit_box .btn_jump").hide();
    						$("body .modal.baigoSubmit_box .box_msg").removeClass(opts.class_ok + " " + opts.class_err);
    						$("body .modal.baigoSubmit_box .box_msg").addClass(opts.class_loading);
    						$("body .modal.baigoSubmit_box .box_msg").text(opts.text_submitting); //填充消息内容
    						callModal(); //输出消息
						} else {
    						$(opts.msg_box + " .baigoSubmit_box").removeClass(opts.class_ok + " " + opts.class_err);
    						$(opts.msg_box + " .baigoSubmit_box").addClass(opts.class_loading);
    						$(opts.msg_box + " .baigoSubmit_box").text(opts.text_submitting); //填充消息内容
						}
						$(_btn_submit).attr("disabled", true);

					}, //输出消息
					success: function(_result){ //读取返回结果
						var _image_pre = _result.alert.substr(0, 1);
						var _class;
        				if (_image_pre == "x") {
							_class = opts.class_err;
						} else {
							_class = opts.class_ok;
						}
						if (_is_modal) {
            				if (_image_pre == "x") {
    							$("body .modal.baigoSubmit_box .btn_jump").hide();
    						} else {
    							$("body .modal.baigoSubmit_box .btn_jump").show();
    						}
    						$("body .modal.baigoSubmit_box .box_msg").removeClass(opts.class_loading + " " + opts.class_ok + " " + opts.class_err);
    						$("body .modal.baigoSubmit_box .box_msg").addClass(_class);
    						$("body .modal.baigoSubmit_box .box_msg").text(_result.msg); //填充消息内容
    						$("body .modal.baigoSubmit_box .box_alert").text(_result.alert);
    						callModal(); //输出消息
						} else {
    						$(opts.msg_box + " .baigoSubmit_box").removeClass(opts.class_loading + " " + opts.class_ok + " " + opts.class_err);
    						$(opts.msg_box + " .baigoSubmit_box").addClass(_class);
                            $(opts.msg_box + " .baigoSubmit_box").text(_result.msg);
						}
						$(_btn_submit).removeAttr("disabled");
					}
				});
			}
		}

		return this;
	}

})(jQuery);