<?php
include 'conn.php';
?>
<!DOCTYPE html>
<html>

<head>
	<title>ระบบสนับสนุนการตัดสินใจเลือกอาชีพสำหรับผู้พิการ</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="stylev3.css">
</head>

<body>
	<nav class="navbar">
		<div class="container-nav">
			<a class="navbar-brand" href="index.php">CasebasedOccupation</a>
			<ul class="navbar-nav">
				<li class="nav-item">
					<a class="nav-link" href="index.php">Home</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#">About me</a>
				</li>
			</ul>
		</div>
	</nav>
	<form action="calculator.php" method="post">
		<div class="container">
			<legend align="center">ระบบช่วยสนับสนุนการตัดสินใจเลือกอาชีพสำหรับผู้พิการ</legend>
			<br>
			<label>กรุณากรอกข้อมูลเพื่อทำการวิเคราะห์</label>
			<fieldset class="form-group">
				<label>1. เพศ</label>
				<label class="radio-inline">
					<input type="radio" name="gender" value="ชาย" required>
					<span class="radio-field-fit">
						<span class="radio-label">ชาย</span>
					</span>
				</label>
				<label class="radio-inline">
					<input type="radio" name="gender" value="หญิง">
					<span class="radio-field-fit">
						<span class="radio-label">หญิง</span>
					</span>
				</label>
				<label class="radio-inline">
					<input type="radio" name="gender" value="อื่นๆ">
					<span class="radio-field-fit">
						<span class="radio-label">อื่นๆ</span>
					</span>
				</label>
			</fieldset>

			<fieldset class="form-group">
				<label for="education">2. ระดับการศึกษา</label>
				<select name="education" id="education" class="form-control" style="width: auto;">
					<option value="1">ไม่มี</option>
					<option value="2">ประถมศึกษา</option>
					<option value="3">มัธยมศึกษา</option>
					<option value="4">ศูนย์ฝึกอาชีพผู้พิการ</option>
					<option value="5">ปวช./ปวส.</option>
					<option value="6">ปริญญาตรี</option>
					<option value="7">สูงกว่าปริญญาตรี</option>
				</select>
			</fieldset>

			<fieldset class="form-group">
				<label>3. สถานภาพ</label>
				<select name="status_" id="status" class="form-control" style="width: auto;">
					<option value="โสด">โสด</option>
					<option value="สมรส">สมรส</option>
					<option value="แยกกันอยู่">แยกกันอยู่</option>
					<option value="หย่าร้าง">หย่าร้าง</option>
					<option value="หม้าย">หม้าย</option>
				</select>
			</fieldset>
		</div>
		<div class="container">

			<fieldset class="form-group">
				<label>4. ประเภทความพิการ</label>
				<label class="radio-inline radio-field">
					<input type="radio" name="dis_type" value="1" onclick="updateDropdown()" required>
					ประเภท 1 ด้านการมองเห็น (ตาบอด 1 ข้าง)
				</label><br>
				<label class="radio-inline radio-field">
					<input type="radio" name="dis_type" value="9" onclick="updateDropdown()">
					ประเภท 1 ด้านการมองเห็น (ตาบอด 2 ข้าง)
				</label><br>
				<label class="radio-inline radio-field">
					<input type="radio" name="dis_type" value="2" onclick="updateDropdown()">
					ประเภท 2 ด้านการได้ยิน (หูตึง หรือ ใส่เครื่องช่วยฟัง)
				</label><br>
				<label class="radio-inline radio-field">
					<input type="radio" name="dis_type" value="4" onclick="updateDropdown()">
					ประเภท 2 ด้านการได้ยิน (เป็นใบ้ พูดไม่ได้)
				</label><br>
				<label class="radio-inline radio-field">
					<input type="radio" name="dis_type" value="3" onclick="updateDropdown()">
					ประเภท 3 ด้านการเคลื่อนไหว (ยังสามารถเดินได้)
				</label><br>
				<label class="radio-inline radio-field">
					<input type="radio" name="dis_type" value="8" onclick="updateDropdown()">
					ประเภท 3 ด้านการเคลื่อนไหว (ไม่สามารถเดินได้)
				</label><br>
				<label class="radio-inline radio-field">
					<input type="radio" name="dis_type" value="7" onclick="updateDropdown()">
					ประเภท 4 ด้านจิตใจหรือพฤติกรรม
				</label><br>
				<label class="radio-inline radio-field">
					<input type="radio" name="dis_type" value="6" onclick="updateDropdown()">
					ประเภท 5 ด้านสติปัญญาและการเรียนรู้
				</label 2 bel><br>
				<label class="radio-inline radio-field">
					<input type="radio" name="dis_type" value="5" onclick="updateDropdown()">
					ประเภท 5 ออทิสติก
				</label> <!-- ออทิสติก1 ด้านสติปัญญาและการเรียนรู้2 ด้านจิตใจหรือพฤติกรรม3 -->
			</fieldset>


			<fieldset class="form-group">
				<label>5. มีอุปกรณ์อำนวยความสะดวกหรือไม่ โปรดระบุ เช่น เครื่องช่วยฟัง
					<br>&nbsp;&nbsp;&nbsp;&nbsp;รถเข็น(วีลแชร์) อื่นๆ</label>
				<select id="tool" name="tool" style="width: 38%;">
				</select>
				<input type="text" name="tool" id="toolfree" style="width: 38%; display: none;"
					placeholder="โปรดระบุ..." disabled>
				<!-- เดินไม่ได้ = วิลแชร์ ยังเดินได้ = ขาเทียม, ไม้ค้ำยัน, ไม้เท้า, วิลแชร์ หูตึง = เครื่องช่วยฟัง, เขียนพิมพ์สื่อสาร ตาบอด = ไม้เท้า -->
			</fieldset>

			<fieldset class="form-group">
				<label>6. มีผู้ดูแลหรือไม่</label>
				<label class="radio-inline"><input type="radio" name="keepercheck" id="keepernone" value="ไม่มี"
						onclick="disableKeeper()">ไม่มี</label>
				<label class="radio-inline"><input type="radio" name="keepercheck" id="keeperhave" value="มี"
						onclick="disableKeeper()">มี เกี่ยวข้องเป็น</label>
				<select name="keeper" id="keeper" class="form-control-lg" style="width: auto;" disabled>
					<option></option>
					<option value="บิดา/มารดา">บิดา/มารดา</option>
					<option value="พี่/น้อง">พี่/น้อง</option>
					<option value="สามี/ภรรยา">สามี/ภรรยา</option>
					<option value="ลูก/หลาน">ลูก/หลาน</option> <!-- สมรส1 แยกกันอยู่2 โสด3 หย่าร้าง4 หม้าย5  -->
					<option value="คนอื่นๆในครอบครัว">คนอื่นๆในครอบครัว</option>
					<option value="จ้างคนมาดูแล">จ้างคนมาดูแล</option>
				</select>
				<!-- การช่วยเหลือจากบริษัท จ้างคนมาดูแล พี่/น้องเขย พี่/น้องสะใภ้ สามี/ภรรยา พี่/น้อง ลูก/หลาน บิดา/มารดา ครอบครัว -->
			</fieldset>
		</div>

		<div class="container">
			<fieldset class="form-group">
				<label>8. เงินลงทุนที่มีสำหรับประกอบอาชีพ โปรดระบุจำนวนเงิน</label>
				<label class="radio-inline"><input type="radio" name="investcheck" id="investnone" value="ไม่มี"
						onclick="disableInvest()">ไม่มี</label>
				<label class="radio-inline"><input type="radio" name="investcheck" id="investhave" value="มี"
						onclick="disableInvest()">มี
					<input type="text" id="invest" name="invest" size="7" style="width: auto;" min="0" max="9999999"
						disabled>
					บาท</label>
			</fieldset>

			<fieldset class="form-group">
				<label>9. เคยกู้ยืมเงินผู้พิการเพื่อประกอบอาชีพหรือไม่ โปรดระบุจำนวนเงินที่กู้ยืม</label>
				<label class="radio-inline"><input type="radio" name="loancheck" id="loannone" value="ไม่มี"
						onclick="disableLoan()">ไม่เคย</label>
				<label class="radio-inline"><input type="radio" name="loancheck" id="loanhave" value="มี"
						onclick="disableLoan()">เคย
					<input type="text" id="loan" name="loan" size="6" style="width: auto;" min="0" max="100000"
						disabled>
					บาท</label><!-- 0-10000, 10000-20000, 20000-40000, >40000 -->
			</fieldset>

			<fieldset class="form-group">
				<label>7. งานอดิเรก</label>
				<label class="checkbox-label">
					<input type="checkbox" id="hobbynone" value="ไม่มี" onclick="disableCheckboxesHobby()">
					ไม่มี
					<span class="checkbox-checkmark"></span>
				</label><br>

				<div class="checkbox-form">
					<div class="column">
						<label class="checkbox-label">
							<input type="checkbox" name="hobby[]" value="ทำงานฝีมือ/งานศิลปะ">
							ทำงานฝีมือ/งานศิลปะ
							<span class="checkbox-checkmark"></span>
						</label><br>
						<label class="checkbox-label">
							<input type="checkbox" name="hobby[]" value="ทำงานประดิษฐ์/งานช่าง">
							ทำงานประดิษฐ์/งานช่าง
							<span class="checkbox-checkmark"></span>
						</label><br>
						<label class="checkbox-label">
							<input type="checkbox" name="hobby[]" value="เล่นกีฬา/ออกกำลังกาย">
							เล่นกีฬา/ออกกำลังกาย
							<span class="checkbox-checkmark"></span>
						</label><br>
						<label class="checkbox-label">
							<input type="checkbox" name="hobby[]" value="เสริมสวย/แต่งหน้า/ทำผม">
							เสริมสวย/แต่งหน้า/ทำผม
							<span class="checkbox-checkmark"></span>
						</label><br>
						<label class="checkbox-label">
							<input type="checkbox" name="hobby[]" value="ดูหนัง/ฟังเพลง">
							ดูหนัง/ฟังเพลง
							<span class="checkbox-checkmark"></span>
						</label><br>
					</div>
					<div class="column">
						<label class="checkbox-label">
							<input type="checkbox" name="hobby[]" value="เล่นดนตรี/ร้องเพลง">
							เล่นดนตรี/ร้องเพลง
							<span class="checkbox-checkmark"></span>
						</label><br>
						<label class="checkbox-label">
							<input type="checkbox" name="hobby[]" value="ทำอาหาร">
							ทำอาหาร
							<span class="checkbox-checkmark"></span>
						</label><br>
						<label class="checkbox-label">
							<input type="checkbox" name="hobby[]" value="ปลูกต้นไม้">
							ปลูกต้นไม้
							<span class="checkbox-checkmark"></span>
						</label><br>
						<label class="checkbox-label">
							<input type="checkbox" name="hobby[]" value="เลี้ยงสัตว์">
							เลี้ยงสัตว์
							<span class="checkbox-checkmark"></span>
						</label><br>
					</div>
				</div>
				<label class="checkbox-label">
					<input type="checkbox" id="hobbyother" onclick="disableCheckboxesOther()">
					อื่นๆ
					<span class="checkbox-checkmark"></span>
				</label>
				<input type="text" name="hobby[]" id="hobby" placeholder="โปรดระบุ..." disabled>
			</fieldset>

			<fieldset class="form-group">
				<label>8. ความถนัด</label>
				<label class="checkbox-label"><input type="checkbox" id="aptitudenone" value="ไม่มี"
						onclick="disableCheckboxesAptitude()">ไม่มี
					<span class="checkbox-checkmark"></span>
				</label>

				<div class="checkbox-form">
					<div class="column">
						<label class="checkbox-label"><input type="checkbox" name="aptitude[]" value="ด้านภาษา">ด้านภาษา
							<span class="checkbox-checkmark"></span>
						</label><br>
						<label class="checkbox-label"><input type="checkbox" name="aptitude[]"
								value="ด้านคอมพิวเตอร์">ด้านคอมพิวเตอร์
							<span class="checkbox-checkmark"></span>
						</label><br>
						<label class="checkbox-label"><input type="checkbox" name="aptitude[]"
								value="ด้านการค้า">ด้านการค้า
							<span class="checkbox-checkmark"></span>
						</label><br>
						<label class="checkbox-label"><input type="checkbox" name="aptitude[]"
								value="ด้านตรรกะ">ด้านตรรกะ
							<span class="checkbox-checkmark"></span>
						</label><br>
						<label class="checkbox-label"><input type="checkbox" name="aptitude[]"
								value="ด้านดนตรี">ด้านดนตรี
							<span class="checkbox-checkmark"></span>
						</label><br>
					</div>
					<div class="column">
						<label class="checkbox-label"><input type="checkbox" name="aptitude[]"
								value="ด้านการช่าง/ซ่อมแซม">ด้านการช่าง/ซ่อมแซม
							<span class="checkbox-checkmark"></span>
						</label><br>
						<label class="checkbox-label"><input type="checkbox" name="aptitude[]"
								value="ด้านศิลปะ/การช่าง">ด้านศิลปะ/งานฝีมือ
							<span class="checkbox-checkmark"></span>
						</label><br>
						<label class="checkbox-label"><input type="checkbox" name="aptitude[]" value="ด้านกีฬา">ด้านกีฬา
							<span class="checkbox-checkmark"></span>
						</label><br>
						<label class="checkbox-label"><input type="checkbox" name="aptitude[]"
								value="ด้านมนุษย์สัมพันธ์">ด้านมนุษย์สัมพันธ์
							<span class="checkbox-checkmark"></span>
						</label><br>
						<label class="checkbox-label"><input type="checkbox" name="aptitude[]"
								value="ด้านการเกษตร">ด้านการเกษตร
							<span class="checkbox-checkmark"></span>
						</label><br>
					</div>
				</div>
				<label class="checkbox-label"><input type="checkbox" id="aptitudeother"
						onclick="disableCheckboxesAother()">อื่นๆ
					<span class="checkbox-checkmark"></span>
				</label>
				<input type="text" name="aptitude[]" id="aptitude" placeholder="โปรดระบุ..." disabled>
			</fieldset>

			<fieldset class="form-group">
				<label>9. วิธีเดินทางไปทำงาน</label><br>

				<div class="checkbox-form">
					<div class="column">
						<label class="checkbox-label"><input type="checkbox" name="commute[]"
								value="รถยนต์ส่วนตัว">รถยนต์ส่วนตัว
							<span class="checkbox-checkmark"></span></label><br>
						<label class="checkbox-label"><input type="checkbox" name="commute[]"
								value="รถจักรยานยนต์ส่วนตัว">รถจักรยานยนต์ส่วนตัว<span
								class="checkbox-checkmark"></span>
						</label><br>
						<label class="checkbox-label"><input type="checkbox" name="commute[]"
								value="รถโดยสารประจำทาง">รถโดยสารประจำทาง<span class="checkbox-checkmark"></span>
						</label><br>
						<label class="checkbox-label"><input type="checkbox" name="commute[]"
								value="เดินเท้า">จักรยาน<span class="checkbox-checkmark"></span>
						</label><br>
					</div>
					<div class="column">
						<label class="checkbox-label"><input type="checkbox" name="commute[]"
								value="เดินเท้า">ติดรถผู้อื่นไปทำงาน<span class="checkbox-checkmark"></span>
						</label><br>
						<label class="checkbox-label"><input type="checkbox" name="commute[]"
								value="เดินเท้า">เดินเท้า<span class="checkbox-checkmark"></span>
						</label> <br>
						<label class="checkbox-label"><input type="checkbox" name="commute[]"
								value="ทำงานที่บ้าน (WFH)">ทำงานที่บ้าน (WFH)<span class="checkbox-checkmark"></span>
						</label>
					</div>
				</div>
			</fieldset>
			<fieldset>
				<button class="btn btn-success" type="submit" name="submit" value="submit">ดูผลการวิเคราะห์</button>
			</fieldset>
		</div>
	</form>
	<div class="float-button-container">
		<button class="float-btn" onclick="toggleFontSize()">Aa</button>
	</div>

	<script>
		function toggleFontSize() {
			var body = document.getElementsByTagName("body")[0];
			var floatBtn = document.getElementsByClassName("float-btn")[0];

			if (body.classList.contains("increase-font")) {
				body.classList.remove("increase-font");
				floatBtn.classList.remove("active");
			} else {
				body.classList.add("increase-font");
				floatBtn.classList.add("active");
			}
		}

		function toggleColorMode() {
			var body = document.getElementsByTagName("body")[0];
			var floatBtn = document.getElementsByClassName("float-btn")[0];

			if (body.classList.contains("inverted-color")) {
				body.classList.remove("inverted-color");
				floatBtn.classList.remove("inverted");
			} else {
				body.classList.add("inverted-color");
				floatBtn.classList.add("inverted");
			}
		}

		function disableInvest() {
			if (document.getElementById("investnone").checked) {
				document.getElementById("invest").disabled = true;
				document.getElementById("invest").value = "";
			} else if (document.getElementById("investhave").checked) {
				document.getElementById("invest").disabled = false;
			}
		}
		function disableLoan() {
			if (document.getElementById("loannone").checked) {
				document.getElementById("loan").disabled = true;
				document.getElementById("loan").value = "";
			} else if (document.getElementById("loanhave").checked) {
				document.getElementById("loan").disabled = false;

			}
		}

		function disableKeeper() {
			if (document.getElementById("keepernone").checked) {
				document.getElementById("keeper").disabled = true;
				document.getElementById("keeper").value = "";
			} else if (document.getElementById("keeperhave").checked) {
				document.getElementById("keeper").disabled = false;
			}
		}

		function disableCheckboxesAother() {
			if (document.getElementById("aptitudeother").checked) {
				document.getElementById("aptitude").disabled = false;
			} else {
				document.getElementById("aptitude").disabled = true;
				document.getElementById("aptitude").value = "";
			}
		}

		function disableCheckboxesOther() {
			if (document.getElementById("hobbyother").checked) {
				document.getElementById("hobby").disabled = false;
			} else {
				document.getElementById("hobby").disabled = true;
				document.getElementById("hobby").value = "";
			}
		}


		function disableCheckboxesHobby() {
			var checkboxes = document.querySelectorAll('input[name="hobby[]"]');
			var checkButton = document.querySelector('input[value="ไม่มี"]');

			if (document.getElementById("hobbynone").checked) {
				checkboxes.forEach(function (checkbox) {
					checkbox.disabled = true;
					checkbox.checked = false;
					document.getElementById("hobby").value = "";
					document.getElementById("hobbyother").disabled = true;
					document.getElementById("hobbyother").checked = false;
				});
			} else {
				checkboxes.forEach(function (checkbox) {
					checkbox.disabled = false;
					document.getElementById("hobbyother").disabled = false;
					document.getElementById("hobby").disabled = true;
				});
			};
		}

		function disableCheckboxesAptitude() {
			var checkboxes = document.querySelectorAll('input[name="aptitude[]"]');
			var checkButton = document.querySelector('input[value="ไม่มี"]');

			if (document.getElementById("aptitudenone").checked) {
				checkboxes.forEach(function (checkbox) {
					checkbox.disabled = true;
					checkbox.checked = false;
					document.getElementById("aptitude").value = "";
					document.getElementById("aptitudeother").disabled = true;
					document.getElementById("aptitudeother").checked = false;
				});
			} else {
				checkboxes.forEach(function (checkbox) {
					checkbox.disabled = false;
					document.getElementById("aptitudeother").disabled = false;
					document.getElementById("aptitude").disabled = true;
				});
			};
		}


		function updateDropdown() {
			var disTypeRadios = document.getElementsByName("dis_type");
			var toolSelect = document.getElementById("tool");
			var toolFreeInput = document.getElementById("toolfree");
			// Get the selected dis_type value
			var disType;
			for (var i = 0; i < disTypeRadios.length; i++) {
				if (disTypeRadios[i].checked) {
					disType = disTypeRadios[i].value;
					break;
				}
			}

			// Clear the existing options
			toolSelect.innerHTML = "";

			// Define the options based on the dis_type value
			var options;
			if (disType === "1" || disType === "9") {
				options = ["ไม่มี", "ไม้เท้า", "อื่นๆ"];
			} else if (disType === "2" || disType === "4") {
				options = ["ไม่มี", "เครื่องช่วยฟัง", "เขียนพิมพ์สื่อสาร", "อื่นๆ"];
			} else if (disType === "3" || disType === "8") {
				options = ["ไม่มี", "ไม้ค้ำยัน", "ไม้เท้า", "วิลแชร์", "ขาเทียม", "อื่นๆ"];
			} else if (disType === "5" || disType === "6" || disType === "7") {
				options = ["ไม่มี", "อื่นๆ"];
			} else {
				options = ["กรุณาตอบคำถามก่อนหน้า"]; // Default empty options
			}

			// Create and append new option elements
			for (var j = 0; j < options.length; j++) {
				var option = document.createElement("option");
				option.value = options[j];
				option.text = options[j];
				toolSelect.appendChild(option);
			}

			toolSelect.addEventListener("change", function () {
				if (toolSelect.value === "อื่นๆ") {
					toolFreeInput.disabled = false;
					toolFreeInput.style.display = "block";
					toolFreeInput.style.display = "inline-block";
				} else {
					toolFreeInput.disabled = true;
					toolFreeInput.value = "";
					toolFreeInput.style.display = "none";
				}
			});

		}
		// Initialize the dropdown on page load
		updateDropdown();
	</script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>

</html>