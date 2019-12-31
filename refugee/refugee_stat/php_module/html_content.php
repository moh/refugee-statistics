<?php
$html_content = '
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="AR-SA" xml:lang="AR-SA">
<head>
    <meta charset="UTF-8" />
    <title>استمارة جمعية</title>
    <link rel="stylesheet" href="style/index1.css">
    <script src="scripts/index1.js"></script>
</head>


<body>
    <img src="../../images/logo.jpg" id="logo_image"/>
    <form name="Tables_forum" action="check_data.php" id="form1" method="post" onsubmit="return submit_data();">
    <div class = "tables">
        <table>
            <tr>
                <th colspan="4">معلومات عامة</th>
            </tr>
            <tr>
                <td >الاسم : <input type="text" name="name" class="err_check read_only" required/></td>
                <td >الشهرة : <input type="text" name="family_name" class="err_check read_only" required/> </td>
                <td >اسم الاب : <input type="text" name="father_name" class="err_check read_only" required/></td>
                <td>اسم الجد : <input type="text" name="grand_father_name" required/></td>
            </tr>
            <tr>
                <td>اسم الأم : <input type="text" name="mother_name" /></td>
                <td>تاريخ الولادة : <input type="date" name="age" class="read_only" required/> </td>
				<td>اسم الزوجة1 : <input type="text" name="wife1_name" required/> </td>
                <td>رقم الهاتف  :  <input type="text" name="t_number" class="err_check" required/></td>

            </tr>
            <tr>
                <td>الجنسية : <input type="text" name="nationality" class="err_check read_only"  required/></td>
                <td>رقم الامم المتحدة : <input type="text" name="un_number"/></td>
                <td>فئة الدم : <input type="text" name="blood_type"/></td>
                <td>المهنة :  <input type="text" name="work"/></td>
            </tr>
            <tr>
                <td>الوضع الصحي :
                    <select name="health">
                        <option value="1">سليم </option>
                        <option value="2">مريض</option>
                        <option value="3">مرض مزمن</option>
                    </select>
                </td>
                <td >الوضع العائلي :
                    <select name="family_status">
                        <option value="1">اعزب </option>
                        <option value="2">متزوج</option>
                        <option value="3"> 	ارمل</option>
                        <option value="4">مطلق </option>
                    </select>
                </td>

                <td><p>في حال وجود مرض يتم ذكره مع تكلفة العلاج : </p>
                <textarea name="disease"></textarea></td>
                <td> الاجر : <input type="number" name="salary" min="0"/></td>

            </tr>

        </table>

        <table id="family_stat">
            <tr><th colspan="6">افراد الاسرة</th></tr>
            <tr>
                <th>الاسم</th>
                <th>العلاقة</th>
                <th>الميلاد</th>
                <th>المهنة</th>
                <th>مدرسة</th>
                <th>الاجر</th>
            </tr>
        </table>

        <table>
            <tr>
                <th colspan="4">تفاصيل السكن</th>
            </tr>
            <tr>
                <td>مستأجر (قيمة الايجار) : <input type="number" name="living_price" min="0"/></td>
                <td>خيمة : <input type="checkbox" name="tent"/></td>
                <td>ملك : <input type="checkbox" name="property"/></td>
                <td>غيره : <input type="text" name="living_other"/></td>
            </tr>
            <tr>
                <td colspan="2"> البلدة :  <input type="text" name="city" class="err_check"  required/></td>
                <td>الحي :  <input type="text" name="neighborhood"/></td>
                <td>المبنى :   <input type="text" name="apartement"/></td>
            </tr>
            <tr>
                <td colspan="2">اسم صاحب السكن :  <input type="text" name="address_owner" class="err_check" required/></td>
                <td>رقم الهاتف :  <input type="text" name="add_owner_phone" /></td>
                <td>رقم العقار : <input type="text" name="house_number"/></td>
            </tr>
        </table>
 <table>
            <tr>
                <th colspan="4"> أهم الاحتياجات المطلوبة </th>
            </tr>
            <tr>
                <td>مواد غذائية :  <input type="checkbox" name="need_1" /></td>
                <td>بطانيات : <input type="checkbox" name="need_2" /></td>
                <td>فرش : <input type="checkbox" name="need_3" /></td>
                <td>مازوت للتدفئة : <input type="checkbox" name="need_4" /></td>
            </tr>
            <tr>
                <td>مدفأة  : <input type="checkbox" name="need_5" /></td>
                <td>ملابس : <input type="checkbox" name="need_6" /></td>
                <td>أحذية : <input type="checkbox" name="need_7" /></td>
                <td>مستلزمات رُضع  : <input type="checkbox" name="need_8"/></td>
            </tr>
            <tr>
            	<td colspan="4">اخرى <input type="text" name="need_other"/></td>
            </tr>
        </table>

        <table id="aides">
        	<tr><th colspan="3">نوع المساعدة</th></tr>
            <tr><th>مساعدات</th><th>تفاصيل</th><th>التاريخ</th></tr>
        </table>

        <span>ملاحظات الباحث : <textarea name="note"></textarea></span>

    </div>

        <input type="submit" id = "submit" value="تحفيظ" />
        <button type="button" id="add_aides">اضافة حصة</button>
        <button type="button" id="add_member">اضافة فرد</button>
    
    	<input type="text" id="input2" name="id_selected" style="display:none"/>
    </form>
</body>
';
?>