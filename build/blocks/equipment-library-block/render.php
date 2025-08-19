<link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>

<style>
.active {
	background-color: white !important;
}

.hidden {
	display: none !important;
}

#category-container {
	display: grid;
	grid-template-columns: auto auto auto auto;

}

#vendor-container {
	display: grid;
	grid-template-columns: auto auto auto auto auto;
}

.equipment-box {
	border: 1px solid black;
	border-radius: 5px;
	display: block;
	margin: 5px;
	padding: 5px;
	font-size: 16px;
	text-align: center;
	overflow-y: auto;
	vertical-align: middle;
	background-color: #efeeed;
}

.equipment-box:hover {
	background: white;
	cursor: pointer;
}

#information-container {
	display: grid;
	grid-template-areas:
	'header header header'
    'boxes documents documents';
	margin-top: 50px;
	grid-gap: 30px;
}

#information-header {
	grid-area: header;
	margin: auto;
}

#type-divs {
	width: fit-content;
	cursor: pointer;
	grid-area: boxes;
	width: 310px;
}

#document-div {
	grid-area: documents;
	border: 1px solid black;
	font-size: 18px !important;
	width: 50vw;
	color: #000000 !important;
}

#document-div > a {
	text-decoration: none;
	color: #000000 !important;
}

#document-div > a:hover {
	text-decoration: underline;
}

#document-div-mobile {
	grid-area: documents;
	border: 1px solid black;
	font-size: 18px !important;
	width: 50vw;
	color: #000000 !important;
}

#document-div-mobile > a {
	text-decoration: none;
	color: #000000 !important;
}

#document-div-mobile > a:hover {
	text-decoration: underline;
}

#type-divs > div{
	display: block;
	padding: 5px 15px;
}

.selected {
	color: #EB5600;
	font-weight: 600;
}

.toggle-container {
	display: flex;
	margin-inline: auto;
	width: 50%;
	padding: 2px 5px;
	border-radius: 5px;
	border: black solid 1px;
	background-color: #ebebeb;
	position: relative;
	margin-bottom: 50px;
}

.toggle-container input[type="radio"] {
  display: none;
}

.toggle-option {
  flex: 1;
  text-align: center;
  line-height: 40px;
  cursor: pointer;
  z-index: 2;
  font-weight: 500;
  color: #333;
  transition: color 0.3s ease;
}

.toggle-slider {
  position: absolute;
  top: 2px;
  bottom: 2px;
  left: 2px;
  width: calc(50% - 4px);
  background-color: white;
  border-radius: 6px;
  box-shadow: 0 2px 5px rgba(0,0,0,0.15);
  transition: left 0.3s ease;
  z-index: 1;
}

#vendors:checked ~ .toggle-slider {
  left: calc(50% + 2px);
}

#categories:checked ~ label[for="categories"],
#vendors:checked ~ label[for="vendors"] {
  color: #000;
  font-weight: 600;
}

.equipment-library-content {
	font-family: 'Poppins';
	font-size: 22px;
	padding: 10px 50px 100px 50px;
}

#mobile-view {
	display: none;
}

@media screen and (max-width: 900px){
	#type-divs {
		width: 200px;
	}

	#document-div {
		width: 450px;
	}
}

@media screen and (max-width: 767px){
	#desktop-tablet-view {
		display: none;
	}
	#mobile-view {
		display: block;
	}
}

#loader {
  position: fixed;
  left: 50%;
  top: 50%;
  z-index: 1;
  width: 120px;
  height: 120px;
  margin: -76px 0 0 -76px;
  border: 16px solid #f3f3f3;
  border-radius: 50%;
  border-top: 16px solid orange;
  -webkit-animation: spin 2s linear infinite;
  animation: spin 2s linear infinite;
}

@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

</style>
<div id="loader"></div>
<div id="mobile-view">
	<div id="type-dropdown-container">
		<select id="type-dropdown">
			<option value="category">Categories</option>
			<option value="vendor">Vendors</option>
		</select>
	</div>
	<div id="category-dropdown-container" class="">
		<select id="category-dropdown">
			<option value="" id="default" hidden>Please select an option</option>
			<?php
			$groupId = $attributes['group'];
			$fields = acf_get_fields($groupId);
			$categories = $fields[2]['choices'];
			foreach ($categories as $category):?>
				<option value="<?=$category?>" >
					<?=$category?>
				</option>
			<?php 
			endforeach;
			?>
		</select>
	</div>
	<div id="vendor-dropdown-container" class="hidden">
		<select id="vendor-dropdown">
			<option value="" id="default" hidden>Please select an option</option>
			<?php
		/*
			dev: group_67c20024bd9be
			local: group_67c1f4ee1c252
		*/
		$fields = acf_get_fields($groupId);
		$vendors = $fields[3]['choices'];
		foreach ($vendors as $vendor):?>
			<option value="<?=$vendor?>">
				<?=$vendor?>
			</option>
		<?php 
		endforeach;
		?>
		</select>
	</div>
	<div id="document-types-container">
		<select id="document-types-dropdown" disabled>
			<option value="" id="default" hidden>Please select an option</option>
			<option value="article" id="article-option">Articles</option>
			<option value="brochure" id="brochure-option">Brochures & Documents</option>
			<option value="tidbit" id="tidbit-option">Equipment Tidbits</option>
			<option value="manual" id="manual-option">Product Manuals</option>
			<option value="video" id="video-option">Videos</option>
		</select>
	</div>
	<div id="search-button">
		<button onclick="fillMobileDocuments()">View Equipment Documents</button>
	</div>
	<div id="document-div-mobile" class="hidden">
		<ul id="document-list-mobile">
		</ul>
	</div>
</div>
<div id="desktop-tablet-view" class="equipment-library-content">
	<div class="toggle-container">
		<input type="radio" id="categories" name="toggle" checked>
		<label for="categories" class="toggle-option">Categories</label>

		<input type="radio" id="vendors" name="toggle">
		<label for="vendors" class="toggle-option">Vendors</label>

		<div class="toggle-slider"></div>
	</div>
	<div id="category-container" class="hidden">
		<?php
		/*
			dev: group_67c20024bd9be
			local: group_67c1f4ee1c252
		*/
		$groupId = $attributes['group'];
		$fields = acf_get_fields($groupId);
		$categories = $fields[2]['choices'];
		foreach ($categories as $category):?>
			<div id="<?=$category?>" class="equipment-box">
				<?=$category?>
			</div>
		<?php 
		endforeach;
		?>
	</div>
	<div id='vendor-container' class="hidden">
	<?php
		/*
			dev: group_67c20024bd9be
			local: group_67c1f4ee1c252
		*/
		$fields = acf_get_fields($groupId);
		$vendors = $fields[3]['choices'];
		foreach ($vendors as $vendor):?>
			<div id="<?=$vendor?>" class="equipment-box">
				<?=$vendor?>
			</div>
		<?php 
		endforeach;
		?>
	</div>
	<div id="information-container" tabindex="0" class="hidden" style="outline: 0">
		<span id="information-header"></span>
		<div id="type-divs">
			<div id="article">
				Articles
			</div>
			<div id="brochure">
				Brochures & Documents
			</div>
			<div id="tidbit">
				Equipment TidBits
			</div>
			<div id="manual">
				Product Manuals
			</div>
			<div id="video">
				Videos
			</div>
		</div>
		<div id="document-div">
			<ul id="document-list">
			</ul>
		</div>
	</div>
</div>

<script>

	function displayDiv(){
		if(document.getElementById('categories').checked){
			document.getElementById('category-container').classList.remove('hidden')
		} else {
			document.getElementById('vendor-container').classList.remove('hidden');
		}
		if(document.getElementById('type-dropdown').value === 'category'){
			document.getElementById('category-dropdown-container').classList.remove('hidden');
		} else {
			document.getElementById('vendor-dropdown-container').classList.remove('hidden');
		}
	}
	
	function hideLoader(){
		document.getElementById("loader").style.display = "none";
	}

	function showLoader(){
		document.getElementById("loader").style.display = "block";
	}

	window.addEventListener('load', () => {
		hideLoader();
		displayDiv();
	})

	/*
		Get valid document types for the selected category

		informationType:string - "category" || "vendor"
		category:string - contains the category or vendor name

		Return: list - true if documents are assigned, false if not.
	*/
	async function getValidDocuments(informationType, category){
		var validDocumentTypes;
		if(informationType==="category"){
			//Fetch all current valid document types for the category
			const validDocumentTypesReq = await fetch(`/wp-json/mvs/v1/get-document-types?category=${category}`);
			validDocumentTypes = await validDocumentTypesReq.json();
		} else {
			//Fetch all current valid document types for the vendor
			const validDocumentTypesReq = await fetch(`/wp-json/mvs/v1/get-document-types?vendor=${category}`);
			validDocumentTypes = await validDocumentTypesReq.json();
		}
		if(validDocumentTypes.length === 0){
			return [];
		}
		validDocumentTypes.forEach((type)=> {
			//Show the documents types that are assigned to the category.
			document.getElementById(type).classList.remove('hidden');
			document.getElementById(`${type}-option`).classList.remove('hidden');
		})
		return validDocumentTypes;
	}


	/*
		Fill document section

		informationType:string - "category" || "vendor"
		category:string - contains the category or vendor name
		activeDocumentType: string - contains the previously selected document type
		type: string - type of document that was requested "brochure", "video", etc...

		Return: list - true if documents are assigned, false if not.
	*/
	async function fillDocumentList(informationType, category, activeDocumentType, type) {
		var data;
		if(informationType=="category"){
			//Fetch all current documents for the requested category and document type.
			const req = await fetch(`/wp-json/mvs/v1/equipment-documents?category=${category}&type=${type}`);
			data = await req.json();
		} else {
			//Fetch all current documents for the requested category and document type.
			const req = await fetch(`/wp-json/mvs/v1/equipment-documents?vendor=${category}&type=${type}`);
			data = await req.json();
		}
		var listString = '';
		//Create and fill a string that contains the list items.
		data.forEach((doc)=> {
			listString += `<li><a href="${doc.file}" target="_blank">${doc.name}</li>`;
		})
		//Add the list string to the page as HTML
		document.getElementById("document-list").innerHTML = listString;
		document.getElementById("document-list-mobile").innerHTML = listString;
		//Add information header to HTML
		let documentType;
		switch(type) {
			case "brochure":
				documentType = "Documents";
				break;
			case "article":
				documentType = "Articles";
				break;
			case "tidbit":
				documentType = "TidBits";
				break;
			case "manual":
				documentType = "Product Manuals";
				break;
			case "video":
				documentType = "Videos";
				break;
			default:
				break;
		}
		document.getElementById("information-header").innerHTML = `<span id="activeCategory">${category}</span> Equipment ${documentType}`;
		if(activeDocumentType !== null){
			//Remove the selected class from the last active document type.
			document.getElementById(activeDocumentType).classList.remove('selected');
			console.log("Removed selected from", activeDocumentType)
		}
		//Add the selected class to the new document type
		console.log("Setting selected to", type)
		document.getElementById(type).classList.add('selected');
		//Show and focus the document area.
		hideLoader();
		document.getElementById("information-container").classList.remove('hidden');
		document.getElementById("information-container").focus();
		document.getElementById("document-div-mobile").classList.remove('hidden');
		document.getElementById("document-div-mobile").focus();
		
	}

	async function fillMobileDocuments() {
		const type = document.getElementById("type-dropdown").value;
		let category;
		if(type === "category"){
			category = document.getElementById('category-dropdown').value;
		} else {
			category = document.getElementById('vendor-dropdown').value;
		}
		const documentType = document.getElementById('document-types-dropdown').value;
		await fillDocumentList(type, category, null, documentType)
	}

	async function resetActive(){
		console.log("reseting active")
		const boxes = document.getElementsByClassName('equipment-box');
		for (let i=0;i<boxes.length;i++) {
			if(boxes[i].classList.contains('active')){
				boxes[i].classList.remove('active');
				return;
			}
		};
	}
	//Top Category Button Press
	document.getElementById("categories").addEventListener("click", ()=> {
		resetActive();
		document.getElementById("category-container").classList.remove('hidden');
		document.getElementById("vendor-container").classList.add("hidden");
		document.getElementById("information-container").classList.add('hidden');
	});
	//Top Vendor Button Press
	document.getElementById("vendors").addEventListener("click", ()=> {
		resetActive();
		document.getElementById("vendor-container").classList.remove('hidden');
		document.getElementById("category-container").classList.add("hidden");
		document.getElementById("information-container").classList.add('hidden');
	});
	//Equipment Box Press
	document.querySelectorAll('.equipment-box').forEach((el)=>{
		el.addEventListener("click", async ()=> {
			showLoader();
			//Hide each document type
			for (let child of document.getElementById('type-divs').children){
				child.classList.add('hidden');
			}
			//Hide information container
			document.getElementById("information-container").classList.add('hidden');
			//Check which library is actively checked
			let activeLibrary = document.getElementById('categories').checked ? 'category' : 'vendor';
			let activeDocumentType, activeCategory;
			try {
				//Get current selected document type
				activeDocumentType = document.getElementsByClassName('selected')[0].id;
				//Remove active class from currently selected category
				try {
					document.getElementsByClassName('active')[0].classList.remove('active');
				} catch {}
			} catch (e) {
				//No selected document type
				console.log(e)
				activeDocumentType=null;
			}
			//Add active class to newly clicked category
			el.classList.add('active');
			//Get valid document types
			let validDocuments = await getValidDocuments(activeLibrary, el.id);
			//If there are valid documents then fill the document list.
			if(validDocuments.length !== 0){
				await fillDocumentList(activeLibrary, el.id, activeDocumentType, validDocuments[0])
			}
		})
	})
	//Information div press
	const children = document.getElementById("type-divs").children;
	for (let child of children){
		child.addEventListener("click", async() => {
			showLoader();
			//Check which library is actively checked
			let activeLibrary = document.getElementById('categories').checked ? 'category' : 'vendor';
			//Check which category is active
			let activeCategory = document.getElementById('activeCategory').innerHTML;
			let activeDocumentType;
			try {
				//Get current selected document type
				activeDocumentType = document.getElementsByClassName('selected')[0].id;
			} catch {
				//No selected document type
				activeDocumentType=null;
			}
			//Fill the document list based on the new document type.
			await fillDocumentList(activeLibrary, activeCategory, activeDocumentType, child.id);
		})
	}

	document.getElementById("type-dropdown").addEventListener("change", ()=> {
		if(document.getElementById("type-dropdown").value==="category"){
			document.getElementById("category-dropdown-container").classList.remove('hidden');
			document.getElementById("vendor-dropdown-container").classList.add('hidden');
			document.getElementById("information-container").classList.add('hidden');
		} else {
			document.getElementById("vendor-dropdown-container").classList.remove('hidden');
			document.getElementById("category-dropdown-container").classList.add('hidden');
			document.getElementById("information-container").classList.add('hidden');
		}
		document.getElementById('document-types-dropdown').disabled = true;
	});

	document.getElementById("category-dropdown").addEventListener('change', async (event) => {
		for (let child of document.getElementById('document-types-dropdown').children){
				if(child.id !== 'default'){
					child.classList.add('hidden');
				}
			}
		document.getElementById('document-types-dropdown').selectedIndex = 0;
		document.getElementById('document-types-dropdown').disabled = false;
		let validDocuments = await getValidDocuments(document.getElementById("type-dropdown").value, event.target.value);
	})

	document.getElementById("vendor-dropdown").addEventListener('change', async (event) => {
		for (let child of document.getElementById('document-types-dropdown').children){
				if(child.id !== 'default'){
					child.classList.add('hidden');
				}
			}
		document.getElementById('document-types-dropdown').selectedIndex = 0;
		document.getElementById('document-types-dropdown').disabled = false;
		let validDocuments = await getValidDocuments(document.getElementById("type-dropdown").value, event.target.value);
	})

</script>
<?php



