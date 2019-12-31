function submit_data(){
    var text_elems = document.querySelectorAll("input[type=text]");
    for(var x=0; x<text_elems.length; x++){
        text_elems[x].value = text_elems[x].value.trim();
    }
	var number_elems = document.querySelectorAll("input[type=number]");
	for(var x=0; x<number_elems.length; x++){
    	if(number_elems[x].value == ""){
        	number_elems[x].value="0";
        }
    }
	return confirm("Save Data ? ");
	
}


function add_aides_action(){
    var table = document.getElementById("aides");
    var el_tr = document.createElement("tr");

    var html_content = `
        <td>
            <select name="aides_aides[]">
                <option value="1"> مواد غذائية</option>
                <option value="2"> بطانيات</option>
                <option value="3"> فرش</option>
                <option value="4"> مازوت للتدفئة</option>
                <option value="5"> مدفأة </option>
                <option value="6"> ملابس</option>
                <option value="7"> أحذية</option>
                <option value="8"> مستلزمات رُضع</option>
                <option value="9">حصص اضاحي </option>
                <option value="10">نقدي</option>
            </select>
        </td>
        <td>
            <textarea name="aides_info[]"></textarea>
        </td>
        <td>
            <input type="date" name="aides_dates[]" required/>
        </td>
        <td class="aides_delete">DEL</td>
    `;
    el_tr.innerHTML = html_content;
    table.appendChild(el_tr);
    add_delete_listener();
}

function add_member_action(){
    var table = document.getElementById("family_stat");
    var el_tr = document.createElement("tr");
    var html_cont = `
        <td><input type='text' name='family_names[]' class='err_check' required/></td>
        <td>
            <select name="family_relation[]">
                <option value="1">الأب</option>
                <option value="2">الأم</option>
                <option value="3">الأخ</option>
                <option value="4">الأخت</option>
                <option value="5">الإبن</option>
                <option value="6">الابنة</option>
                <option value="7">زوجة</option>
            </select>
        </td>
        <td>
            <input type="date" name="family_birth[]" required/>
        </td>
        <td>
            <input type="text" name="family_work[]"/>
        </td>
        <td>
            <input type="text" name="family_school[]"/>
        </td>
        <td>
            <input type="number" name="family_salary[]" min="0"/>
        </td>
        <td class="family_delete">DEL</td>
    `;

    el_tr.innerHTML = html_cont;
    table.appendChild(el_tr);
    add_delete_listener();
}

function delete_member() {
    var table = document.getElementById("family_stat");
    table.removeChild(this.parentNode);
}

function delete_aide() {
    var table = document.getElementById("aides");
    table.removeChild(this.parentNode);
}

function add_delete_listener() {
    var deletes_mem = document.getElementsByClassName("family_delete");
    var deletes_aide = document.getElementsByClassName("aides_delete");

    for(var x=0;x<deletes_mem.length;x++){
        deletes_mem[x].addEventListener("click",delete_member);
    }
    for(var x=0; x<deletes_aide.length;x++){
        deletes_aide[x].addEventListener("click",delete_aide);
    }

}


function main(){
    var add_butt = document.getElementById("add_aides");
    var add_member = document.getElementById("add_member");
    add_butt.addEventListener("click",add_aides_action);
    add_member.addEventListener("click",add_member_action);
    add_delete_listener();
}

window.addEventListener("load", main);