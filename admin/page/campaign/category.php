<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=Edge, chrome=1" />
    <meta name="description" content="MOBON" />
    <meta name="keywords" content="MOBON" />
    <meta name="author" content="인라이플" />
    <title>통합카트</title>
    <link type="image/ico" rel="shortcut icon" href="../../image/favicon/favicon.ico">
    <script type="text/javascript" src="../../js/lib/jquery-2.2.2.min.js"></script>
    <script type="text/javascript" src="../../js/lib/jquery.easing.1.3.js"></script>
    <script type="text/javascript" src="../../js/lib/jquery-ui.min.js"></script>
    <script type="text/javascript" src="../../js/lib/moment.min.js"></script>
    <script type="text/javascript" src="../../js/lib/daterangepicker_popup.js"></script>
    <script type="text/javascript" src="../../js/ui.js"></script>
    <link type="text/css" rel="stylesheet" href="../../css/lib/daterangepicker_popup.css" />
    <link type="text/css" rel="stylesheet" href="../../css/common.css">
</head>

<body>
    <!-- 캠페인관리 > 캠페인 카테고리 -->
    <!-- ic_campaignCategory 클래스는 해당 페이지를 구분하는 id 값으로 사용하는 클래스입니다. 
             다른 페이지에는 사용을 지양해주시기 바랍니다.(추후 유지보수때 css 수정 어려움) -->
    <div class="wrap ic_campaignCategory">
        <? include_once $_SERVER['DOCUMENT_ROOT'] . '/admin/page/header.php'; ?>
        <? include_once $_SERVER['DOCUMENT_ROOT'] . '/admin/page/nav.php'; ?>
        <section class="container">
            <div class="title">
                <p>캠페인 카테고리</p>
                <div class="location">
                    <span>캠페인 관리</span><span>캠페인 카테고리</span>
                </div>
            </div>
            <div class="content">
                <section class="sec_list">
                    <div class="tab">
                        <ul>
                            <!-- on 클래스로 탭 제어 -->
                            <li class="on">카테고리 목록 관리</li>
                            <li>카테고리 캠페인 관리</li>
                            <li>인기 캠페인 관리</li>
                        </ul>
                    </div>
                    <div class="tabView">
                        <!-- tab 1 > 카테고리 목록 관리 -->
                        <!--  show 클래스로 탭 제어 -->
                        <div class="tabViewList show">
                            <div class="tableHeader">
                                <div class="tableTitle">
                                    <p>카테고리 목록 관리</p>
                                </div>
                                <div class="buttonBox">
                                    <button type="button" class="register">추가등록</button>
                                    <button type="button" class="rankSave">순위 변경사항 저장</button>
                                </div>
                            </div>
                            <!--// 내용이 없을 때 tableWrap & tableAreaDataNone 함께 사용 -->
                            <!-- <div class="tableArea tableAreaDataNone"> -->
                            <div class="tableArea">
                                <!-- table 스크롤 생기게 하고 싶을 때 tableBox 에 높이값(max-height) 추가-->
                                <div class="tableBox">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>순위</th>
                                                <th>카테고리</th>
                                                <th>캠페인수</th>
                                                <th>관리</th>
                                                <th>순위변경<span class="iBox">
                                                        <span class="iMarkHover">말풍선입니다.</span></span></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>도서/문화</td>
                                                <td>12</td>
                                                <td>
                                                    <div class="buttonBox">
                                                        <button type="button" class="modify" title="수정">수정</button>
                                                        <button type="button" class="delete" title="삭제">삭제</button>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="buttonBox"><button type="button"
                                                            class="listChange">순위변경</button></div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tableDataNone">
                                    <div>
                                        <p>내용이 없습니다. </p>
                                    </div>
                                </div>
                                <div class="paging">
                                    <ul>
                                        <!-- <li class="prev-list"><a href="javascript:pageLink(0);"></a></li> -->
                                        <li class="prev"><a href="javascript:pageLink(0);"></a></li>
                                        <li class="on"><a href="javascript:pageLink(1);">1</a></li>
                                        <li><a href="javascript:pageLink(2);">2</a></li>
                                        <li><a href="javascript:pageLink(3);">3</a></li>
                                        <li><a href="javascript:pageLink(4);">4</a></li>
                                        <li><a href="javascript:pageLink(5);">5</a></li>
                                        <li><a href="javascript:pageLink(6);">6</a></li>
                                        <li><a href="javascript:pageLink(7);">7</a></li>
                                        <li><a href="javascript:pageLink(8);">8</a></li>
                                        <li><a href="javascript:pageLink(9);">9</a></li>
                                        <li><a href="javascript:pageLink(10);">10</a></li>
                                        <li class="next"><a href="javascript:pageLink(10+1);"></a></li>
                                        <!-- <li class="next-list"><a href="javascript:pageLink(10+1);"></a></li> -->
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- tab 2 > 카테고리 캠페인 관리  -->
                        <div class="tabViewList">
                            <div class="tableHeader">
                                <div class="tableTitle">
                                    <p>카테고리 캠페인 관리</p>
                                </div>
                                <div class="selectBox">
                                    <select name="" id="" class="category">
                                        <option value="">카테고리 선택</option>
                                    </select>
                                    <select name="" id="">
                                        <option value="">10개씩 보기</option>
                                    </select>
                                </div>
                                <div class="buttonBox">
                                    <button type="button" class="change">선택변경</button>
                                    <button type="button" class="excelUpload">엑셀 업로드</button>
                                    <button type="button" class="save">변경사항 저장</button>
                                </div>
                            </div>
                            <!--// 내용이 없을 때 tableWrap & tableAreaDataNone 함께 사용 -->
                            <!-- <div class="tableArea tableAreaDataNone"> -->
                            <div class="tableArea">
                                <!-- table 스크롤 생기게 하고 싶을 때 tableBox 에 높이값(max-height) 추가-->
                                <div class="tableBox">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>순서</th>
                                                <th>캠페인명</th>
                                                <th>카테고리 변경</th>
                                                <th>
                                                    <div class="checkBox">
                                                        <input type="checkbox" name="chk2" id="chk2_all">
                                                        <label for="chk2_all">선택</label>
                                                    </div>
                                                </th>
                                                <th>순위변경<span class="iBox">
                                                        <span class="iMarkHover">말풍선입니다.</span></span>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>쿠팡 </td>
                                                <td>
                                                    <div class="buttonBox">
                                                        <button type="button" class="categoryChange">카테고리 변경</button>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="checkBox">
                                                        <input type="checkbox" name="chk2" id="chk2_1">
                                                        <label for="chk2_1"></label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="buttonBox"><button type="button"
                                                            class="listChange">순위변경</button></div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td>G마켓</td>
                                                <td>
                                                    <div class="buttonBox">
                                                        <button type="button" class="categoryChange">카테고리 변경</button>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="checkBox">
                                                        <input type="checkbox" name="chk2" id="chk2_2">
                                                        <label for="chk2_2"></label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="buttonBox"><button type="button"
                                                            class="listChange">순위변경</button></div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tableDataNone">
                                    <div>
                                        <p>내용이 없습니다. </p>
                                    </div>
                                </div>
                                <div class="paging">
                                    <ul>
                                        <!-- <li class="prev-list"><a href="javascript:pageLink(0);"></a></li> -->
                                        <li class="prev"><a href="javascript:pageLink(0);"></a></li>
                                        <li class="on"><a href="javascript:pageLink(1);">1</a></li>
                                        <li><a href="javascript:pageLink(2);">2</a></li>
                                        <li><a href="javascript:pageLink(3);">3</a></li>
                                        <li><a href="javascript:pageLink(4);">4</a></li>
                                        <li><a href="javascript:pageLink(5);">5</a></li>
                                        <li><a href="javascript:pageLink(6);">6</a></li>
                                        <li><a href="javascript:pageLink(7);">7</a></li>
                                        <li><a href="javascript:pageLink(8);">8</a></li>
                                        <li><a href="javascript:pageLink(9);">9</a></li>
                                        <li><a href="javascript:pageLink(10);">10</a></li>
                                        <li class="next"><a href="javascript:pageLink(10+1);"></a></li>
                                        <!-- <li class="next-list"><a href="javascript:pageLink(10+1);"></a></li> -->
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- tab 3 > 인기 캠페인 관리  -->
                        <div class="tabViewList">
                            <div class="tableHeader">
                                <div class="tableTitle">
                                    <p>인기 캠페인 관리</p>
                                </div>
                                <div class="selectBox">
                                    <select name="" id="">
                                        <option value="">10개씩 보기</option>
                                    </select>
                                </div>
                                <div class="buttonBox">
                                    <button type="button" class="change">선택변경</button>
                                    <button type="button" class="excelUpload">엑셀 업로드</button>
                                    <button type="button" class="save">변경사항 저장</button>
                                </div>
                            </div>
                            <!--// 내용이 없을 때 tableWrap & tableAreaDataNone 함께 사용 -->
                            <!-- <div class="tableArea tableAreaDataNone"> -->
                            <div class="tableArea">
                                <!-- table 스크롤 생기게 하고 싶을 때 tableBox 에 높이값(max-height) 추가-->
                                <div class="tableBox">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>순서</th>
                                                <th>캠페인명</th>
                                                <th>삭제</th>
                                                <th>
                                                    <div class="checkBox">
                                                        <input type="checkbox" name="chk3" id="chk3_all">
                                                        <label for="chk3_all">선택</label>
                                                    </div>
                                                </th>
                                                <th>순위변경<span class="iBox">
                                                        <span class="iMarkHover">말풍선입니다.</span></span>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>쿠팡</td>
                                                <td>
                                                    <div class="buttonBox">
                                                        <button type="button" class="delete">삭제</button>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="checkBox">
                                                        <input type="checkbox" name="chk3" id="chk3_1">
                                                        <label for="chk3_1"></label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="buttonBox"><button type="button"
                                                            class="listChange">순위변경</button></div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td>G마켓</td>
                                                <td>
                                                    <div class="buttonBox">
                                                        <button type="button" class="delete">삭제</button>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="checkBox">
                                                        <input type="checkbox" name="chk3" id="chk3_2">
                                                        <label for="chk3_2"></label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="buttonBox"><button type="button"
                                                            class="listChange">순위변경</button></div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tableDataNone">
                                    <div>
                                        <p>내용이 없습니다. </p>
                                    </div>
                                </div>
                                <div class="paging">
                                    <ul>
                                        <!-- <li class="prev-list"><a href="javascript:pageLink(0);"></a></li> -->
                                        <li class="prev"><a href="javascript:pageLink(0);"></a></li>
                                        <li class="on"><a href="javascript:pageLink(1);">1</a></li>
                                        <li><a href="javascript:pageLink(2);">2</a></li>
                                        <li><a href="javascript:pageLink(3);">3</a></li>
                                        <li><a href="javascript:pageLink(4);">4</a></li>
                                        <li><a href="javascript:pageLink(5);">5</a></li>
                                        <li><a href="javascript:pageLink(6);">6</a></li>
                                        <li><a href="javascript:pageLink(7);">7</a></li>
                                        <li><a href="javascript:pageLink(8);">8</a></li>
                                        <li><a href="javascript:pageLink(9);">9</a></li>
                                        <li><a href="javascript:pageLink(10);">10</a></li>
                                        <li class="next"><a href="javascript:pageLink(10+1);"></a></li>
                                        <!-- <li class="next-list"><a href="javascript:pageLink(10+1);"></a></li> -->
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <!--// content end -->
        </section>
        <!--// container end -->
    </div>
</body>

</html>