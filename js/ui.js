/*
File  : ui.js
Date  : 2024.09.26
menu  : 공통 js
*/


//* navigation */ 
var navigation = function(){
  // navigation 메뉴
  $(".navigation > ul > li > a").on("click", function () {
      var nextEl = $(this).next(); // 2deps

      $(".navigation > ul > li").removeClass("on"); // 다른 1deps의 on 클래스 제거
      $(this).closest("li").addClass("on"); // 클릭한 1deps에 on 클래스 추가

      if (nextEl.is("ul") && nextEl.is(":visible")) { 
          $(this).closest("li").removeClass("on");
          nextEl.slideUp(300);
      }
      if (nextEl.is("ul") && !nextEl.is(":visible")) {
          $(".navigation > ul > li > ul:visible").slideUp(300);
          nextEl.slideDown("fast");
      }
      if ($(this).next().length === 0) {
          $(".navigation > ul > li > ul:visible").slideUp(300);
      }
      if (nextEl.is("ul")) {
          return false;
      } else {
          return true;
      }
  });

  // sideNav > menuMore 클릭시 toggle class
  $('.menuMore').on('click',function(){
    $(this).toggleClass('on');
  });

   /* header 유저메뉴 리스트 토글 */
   var menuMore = $("header .sideMenu .userMenu .menuMore");
    $(menuMore).on("click", function () {
        var nextEl = $(this).next("ul");
        $(this).toggleClass("on");
        nextEl.toggle(500);
    });

    $(document).mouseup(function (e) {
      if (!menuMore.is(e.target) && menuMore.has(e.target).length === 0) {
        $(".menuMore + ul").hide(300);
        $(".menuMore + ul").removeClass("on");
      }
    });
};   

//* daterangepicker */ 
var daterangepicker = function () {
  $("[id^='dateInput']").each(function() {
    var _this = this.id;
    $('#'+_this).daterangepicker({
      autoApply: true,
      locale: {
        format: "YYYY-MM-DD",
        daysOfWeek: ["일", "월", "화", "수", "목", "금", "토"],
        monthNames: [
          "01",
          "02",
          "03",
          "04",
          "05",
          "06",
          "07",
          "08",
          "09",
          "10",
          "11",
          "12",
        ],
        customRangeLabel: "사용자 선택",
      },
      ranges: {
        오늘: [moment(), moment()],
        어제: [moment().subtract(1, "days"), moment().subtract(1, "days")],
        이번달: [moment().startOf("month"), moment().endOf("month")],
        전월: [
          moment().subtract(1, "month").startOf("month"),
          moment().subtract(1, "month").endOf("month"),
        ],
        전전월: [
          moment().subtract(2, "month").startOf("month"),
          moment().subtract(2, "month").endOf("month"),
        ],
        "최근 7일": [
          moment().subtract(7, "days"),
          moment().subtract(1, "days"),
        ],
        "최근 30일": [
          moment().subtract(30, "days"),
          moment().subtract(1, "days"),
        ],
        "최근 90일": [
          moment().subtract(90, "days"),
          moment().subtract(1, "days"),
        ],
        "최근 180일": [
          moment().subtract(180, "days"),
          moment().subtract(1, "days"),
        ],
      },
    },
    function (start, end, label) {
      // console.log("Choice Date: " + start.format('YYYYMMDD') + ' ~ ' + end.format('YYYYMMDD'));
      $("input[name=sDate]").val(start.format("YYYYMMDD"));
      $("input[name=eDate]").val(end.format("YYYYMMDD"));
      $("#searchForm").submit();
    }
    );
  });
};

//* 날짜 하루만 선택 */
var daterangepicker_single = function () {
  $("[id^='datePickerS']").each(function() {
    var _this = this.id;
    // var datePicker = ("#datePickerS1 .calendar");
    // var clickOff = ("#datePickerS1.off .calendar")

  $('#'+_this).daterangepicker(
    {
      singleDatePicker: true,
      // showDropdowns: true,
      autoApply: true,
      locale: {
        format: "YYYY-MM-DD",
        daysOfWeek: ["일", "월", "화", "수", "목", "금", "토"],
        monthNames: [
          "01",
          "02",
          "03",
          "04",
          "05",
          "06",
          "07",
          "08",
          "09",
          "10",
          "11",
          "12",
        ],
        customRangeLabel: "사용자 선택",
        ranges: false,
      },
    },
    function (start, end, label) {
      $("input[name=Date]").val(start.format("YYYY-MM-DD"));
    }
  );

  /* input에 yyyy.mm.dd 형태로 날짜 입력 */
  $("input[name=Date]").val($.datepicker.formatDate($.datepicker.ATOM, new Date()));    
  });
};

//* iMark */ 
var iMark = function () {
  var iMarkBtn = $(".iBox");
  iMarkBtn.each(function () {
    //i_mark 마우스 오버 & 마우스 아웃시 말풍선 효과
    $(this).on('mouseover', function () {
      $(this).children(".iMarkHover").css('display', 'block');
    }).on('mouseout', function () {
      $('.iMarkHover').css('display', 'none');
    })
  });
};

var tab = function () {
  $(".tab li").click(function () {
    $(this).closest("section").find(".tab li").removeClass("on");
    var tabIndex = $(this).addClass("on").index();
    var tabListIndex = $(this).closest("section").find(".tabView > .tabViewList");
    $(tabListIndex).removeClass("show");
    $(tabListIndex).eq(tabIndex).addClass("show");
  });
};

//* modalOpen */
var modalOpen = function(){
  $('.modalOpen').click(function(){
        $('#'+$(this).data("popname")+'').addClass('modalOn');
        $("html").css("overflow", "hidden"); 
    }); 
    $('.modalClose, .modalDim').click(function(){
        $(this).parents('.modalWrap').removeClass('modalOn');  
        $("html").css("overflow", "auto");
    }); 
};

//* click 막기 */
var clickOff = function (){
  var clickOff = ('.clickOff');
  $(clickOff).off("click");
};

/* chechbox all */
/* 아이디 값이 all또는 All이 포함되어 있으면 같은 name값을 가진 체크박스들 제어 가능하게 */
var checkboxAll = function(){
  $('input[type="checkbox"]').click(function() {
      var id = $(this).attr('id');
      if (id.includes('all') || id.includes('All')) {
          var name = $(this).attr('name');
          var isChecked = $(this).prop('checked');
          $('input[type="checkbox"][name="' + name + '"]').prop('checked', isChecked);
      } else {
          var name = $(this).attr('name');
          var isChecked = $(this).prop('checked');
          var allCheckbox = $('input[type="checkbox"][name="' + name + '"][id*="all"], input[type="checkbox"][name="' + name + '"][id*="All"]');
          var otherCheckboxes = $('input[type="checkbox"][name="' + name + '"]').not(allCheckbox);
          if (!isChecked && allCheckbox.prop('checked')) {
              allCheckbox.prop('checked', false);
          } else if (isChecked && otherCheckboxes.length === otherCheckboxes.filter(':checked').length) {
              allCheckbox.prop('checked', true);
          }
      }
  });
};




//* common */
$(function () {
  modalOpen();
  clickOff();
  checkboxAll();
  navigation();
  daterangepicker();
  daterangepicker_single();
  iMark();
  tab();
});

