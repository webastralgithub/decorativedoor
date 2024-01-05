jQuery(document).ready(function () {
    // Add More Variant button click event
    jQuery('.add-more-variant').on('click', function () {
        // Clone the last row of fields
        var clonedRow = jQuery('.row-cards:last').clone();

        // Clear the input values in the cloned row
        clonedRow.find('input').val('');
        clonedRow.find('.tag-container').html('');
        clonedRow.find('.tag-container').attr('data-count', parseInt(clonedRow.find('.tag-container').attr('data-count')) + 1);
        clonedRow.find('.edit-variant-tags').attr('data-check', 'new');


        var cloanhtml = `<div class="row row-cards">
        <div class="col-sm-3 col-md-3">
            <label for="category_id" class="form-label">
                Option
                <span class="text-danger">*</span>
            </label>
            <input name="variant_option[]" id="option" class="form-control" placeholder="Like Size, Color..." value="">
        </div>

        <div class="col-sm-8 col-md-8">
            <label for="category_id" class="form-label">
                Value
                <span class="text-danger">*</span>
            </label>
            <input name="variant_option_value[]" id="variant-value" class="form-control" style="display: none;" value="">
            <span class="input-tags">
                <span class="tag-container" id="tagContainer" data-count="1">
                </span>
                <div id="variant_addTag">
                    <input id="variant-tags" class="variant-tags form-control tag-input error" value="" placeholder="Enter variant value seperated by comma">
                </div>

            </span>
        </div>
        <div class="col-sm-1 col-md-1">                   
            <span class="remove-input-tags">
                <button type="button" id="remove-input-variant" class="close-row  btn btn-primary" aria-label="Close">×</button>
            </span>
        </div>
    </div>`;

        // Append the cloned row to the form
        jQuery('.variantForm').append(cloanhtml);

        jQuery('button.close-row.btn.btn-primary').on('click', function(){
            var parentclass = jQuery(this).parent().parent().parent().remove();
            console.log(parentclass);
       });
    });

    // ADD TAGS 
    jQuery('form').on('keydown', '#variant-tags', function (e) {
        if (e.key === 'Enter' || e.key === ',') {
            e.preventDefault();
            addTags(jQuery(this));
        }
    });

    function checkDuplicateTag(tagContainer) {
        var tagTextArray = [];

        tagContainer.find('.tag-text').each(function () {
            tagTextArray.push(jQuery(this).text());
        });
        console.log("already created tags::", tagTextArray);
        return tagTextArray;
    }

    function addTags(currentEle) {
        var tagsInput = currentEle; //jQuery('#variant-tags');
        var optionCheck = currentEle.attr('data-check'); //jQuery('#variant-tags');
        var tagContainer = currentEle.parent().parent().find('.tag-container'); //jQuery('#tagContainer');
        var existingTags = checkDuplicateTag(tagContainer);

        var tags = tagsInput.val().split(',');
        console.log("addTags  -> all tags::", tags, 'existingTags', existingTags);
        tags.forEach(function (tag) {
            tag = tag.trim();
            if (tag !== "") { //&& !existingTags.includes(tag)
                var tagElement = jQuery('<span class="tag"><span class="tag-text">' + tag + '</span><button type="button" class="close" aria-label="Close">×</button></span>');
                tagContainer.append(tagElement);
                // Clear the input field
                tagsInput.val('');
                // Create a new table row for the variant
                jQuery('#variantsTable').css('display', 'block');
                refreshVariantsData(optionCheck);
            }
        });
    }

    function refreshVariantsData(optionCheck = 'new') {
        var tagsWithIndex = [];

        jQuery('.variantForm .row-cards').each(function (index) {
            var parentIndex = index + 1; // Adjust index to start from 1

            var tagNames = [];
            var variantType = '';
            jQuery(this).find('.tag-text').each(function () {
                var tagName = jQuery(this).text().trim();
                tagNames.push(tagName);
            });

            jQuery(this).find('input[name="variant_option[]"]').each(function () {
                variantType = jQuery(this).val();
            });
            tagsWithIndex.push({ index: parentIndex, tagNames: tagNames, variantType: variantType });
        });
        addVariantTableRows(tagsWithIndex, optionCheck);
    }


    function addVariantTableRows(variantsArr = [], optionCheck = 'new') {
        var variantsTableBody = jQuery('#variantsTable tbody');

        const combinations = [];
        const numIndexes = variantsArr.length;

        const numTagNames = variantsArr.map(obj => obj.tagNames.length);
        const indices = new Array(numIndexes).fill(0);

        let done = false;
        while (!done) {
            const current = indices.map((index, i) => variantsArr[i].tagNames[index]);
            combinations.push(current.slice());

            let i = numIndexes - 1;
            for (; i >= 0; i--) {
                indices[i]++;
                if (indices[i] < numTagNames[i]) {
                    break;
                }
                indices[i] = 0;
            }
            if (i < 0) {
                done = true;
            }
        }

        if (optionCheck == 'existing') {

            const lastTag = variantsArr[0].tagNames[variantsArr[0].tagNames.length - 1];

            let tableTR =
                `<tr>
                <input type="hidden" name="variant_option_type[]" class="form-control" value='${JSON.stringify(variantsArr, null, 2)}'>
                <td><input type="text" name="variant_name[]" class="form-control" placeholder="Enter Name" value="${lastTag}"></td>
                <td><input type="text" name="variant_value[]" class="form-control" placeholder="Enter Value" ></td>
                <td><input type="text" name="variant_code[]" class="form-control" placeholder="Enter Code" value="${lastTag}-"></td>
                <td><input type="text" name="variant_quantity[]" class="form-control" placeholder="Enter Quantity"></td>
                <td><input type="text" name="variant_buying_price[]" class="form-control" placeholder="Enter Buying Price"></td>
                <td><textarea name="variant_notes[]" class="form-control" placeholder="Enter Notes"></textarea></td>
            </tr>`;
            variantsTableBody.append(tableTR);

        } else {
            //if (jQuery('.edit-variant-table').length <= 0)
            variantsTableBody.html('');

            combinations.length > 0 && combinations.map((ele, index) => {
                let variantCode = '';
                if (Array.isArray(ele))
                    variantCode = ele.join('/');
                else
                    variantCode = ele;
                    let productCode = jQuery('#productcode').val()
                let tableTR =
                    `<tr>
                <input type="hidden" name="variant_option_type[]" class="form-control" value='${JSON.stringify(variantsArr, null, 2)}'>
                <td><input type="text" name="variant_name[]" class="form-control" placeholder="Enter Name" value="${variantCode}"></td>
                <td><input type="text" name="variant_value[]" class="form-control" placeholder="Enter Value" ></td>
                <td><input type="text" name="variant_code[]" class="form-control" placeholder="Enter Code" value="${variantCode}-${productCode}"></td>
                <td><input type="text" name="variant_quantity[]" class="form-control" placeholder="Enter Quantity"></td>
                <td><input type="text" name="variant_buying_price[]" class="form-control" placeholder="Enter Buying Price"></td>
                <td><textarea name="variant_notes[]" class="form-control" placeholder="Enter Notes"></textarea></td>
            </tr>`;
                variantsTableBody.append(tableTR);
            });
        }
    }

    // Remove tag on close button click
    jQuery('form').on('click', '.close', '#tagContainer', function () {
        jQuery(this).parent().remove();
        refreshVariantsData();
    });

    jQuery('.select-category').select2({
        theme: "classic",
        placeholder: "Select a Category",
        allowClear: true
    });

    jQuery('.select-permissions').select2({
        theme: "classic",
        placeholder: "Select a Permission",
        allowClear: true
    });
    jQuery('.select-sales_users').select2({
        theme: "classic",
        placeholder: "Select a User",
        allowClear: true
    });

    jQuery('.product-title').on('input', function () {
        var name = jQuery(this).val();
        var slug = jQuery.trim(name).replace(/[^a-z0-9-]+/gi, '-').toLowerCase();
        jQuery('.product-slug').val(slug);
    });
});
    ClassicEditor
    .create(document.querySelector('#editor'))
    .then(editor => { console.log(editor); })
    .catch(error => { console.error(error); });

    ClassicEditor
    .create(document.querySelector('#notes'))
    .then(editor => { console.log(editor); })
    .catch(error => { console.error(error); });

    jQuery('.category-name').on('input', function () {
        var name = jQuery(this).val();
        var slug = jQuery.trim(name).replace(/[^a-z0-9-]+/gi, '-').toLowerCase();
        jQuery('.category-slug').val(slug);
    });
// Multiple images preview with JavaScript
var previewImages = function (input, imgPreviewPlaceholder) {

    if (input.files) {
        var filesAmount = input.files.length;

        for (i = 0; i < filesAmount; i++) {
            var reader = new FileReader();

            reader.onload = function (event) {
                jQuery(jQuery.parseHTML('<img>')).attr('src', event.target.result).appendTo(imgPreviewPlaceholder);
            }

            reader.readAsDataURL(input.files[i]);
        }
    }

};

jQuery('button.close-row.btn.btn-primary').on('click', function(){
     var parentclass = jQuery(this).parent().parent().parent().remove();
     console.log(parentclass);
});

// jQuery('#images').on('change', function () {
//     previewImages(this, 'images-preview-div');
// });

// Get the modal
// var modal = document.getElementById("myModal");

// // Get the button that opens the modal
// var btn = document.getElementById("myBtn");

// // Get the <span> element that closes the modal
// var span = document.getElementsByClassName("close-modal")[0];

// // When the user clicks the button, open the modal 
// btn.onclick = function () {
//     modal.style.display = "flex";
// }

// // When the user clicks on <span> (x), close the modal
// span.onclick = function () {
//     modal.style.display = "none";
// }

// // When the user clicks anywhere outside of the modal, close it
// window.onclick = function (event) {
//     if (event.target == modal) {
//         modal.style.display = "none";
//     }
// }
// var memes = [
//     'Dude, you smashed my turtle saying "I\'M MARIO BROS!"',
//     'Dude, you grabed seven oranges and yelled "I GOT THE DRAGON BALLS!"',
//     'Dude, you threw my hamster across the room and said "PIKACHU I CHOOSE YOU!"',
//     'Dude, you congratulated a potato for getting a part in Toy Story',
//     'Dude, you were hugging an old man with a beard screaming "DUMBLEDORE YOU\'RE ALIVE!"',
//     'Dude, you were cutting all my pinapples yelling "SPONGEBOB! I KNOW YOU\'RE THERE!"',
// ];

// var random = document.querySelector('#random');

// random.innerHTML = memes[Math.floor(Math.random() * memes.length)];

// /* Time */

// var deviceTime = document.querySelector('.status-bar .time');
// var messageTime = document.querySelectorAll('.message .time');

// deviceTime.innerHTML = moment().format('h:mm');

// setInterval(function () {
//     deviceTime.innerHTML = moment().format('h:mm');
// }, 1000);

// for (var i = 0; i < messageTime.length; i++) {
//     messageTime[i].innerHTML = moment().format('h:mm A');
// }

// /* Message */

// var form = document.querySelector('.conversation-compose');
// var conversation = document.querySelector('.conversation-container');

// form.addEventListener('submit', newMessage);

// function newMessage(e) {
//     var input = e.target.input;

//     if (input.value) {
//         var message = buildMessage(input.value);
//         conversation.appendChild(message);
//         animateMessage(message);
//     }

//     input.value = '';
//     conversation.scrollTop = conversation.scrollHeight;

//     e.preventDefault();
// }

// function buildMessage(text) {
//     var element = document.createElement('div');

//     element.classList.add('message', 'sent');

//     element.innerHTML = text +
//         '<span class="metadata">' +
//         '<span class="time">' + moment().format('h:mm A') + '</span>' +
//         '<span class="tick tick-animation">' +
//         '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="15" id="msg-dblcheck" x="2047" y="2061"><path d="M15.01 3.316l-.478-.372a.365.365 0 0 0-.51.063L8.666 9.88a.32.32 0 0 1-.484.032l-.358-.325a.32.32 0 0 0-.484.032l-.378.48a.418.418 0 0 0 .036.54l1.32 1.267a.32.32 0 0 0 .484-.034l6.272-8.048a.366.366 0 0 0-.064-.512zm-4.1 0l-.478-.372a.365.365 0 0 0-.51.063L4.566 9.88a.32.32 0 0 1-.484.032L1.892 7.77a.366.366 0 0 0-.516.005l-.423.433a.364.364 0 0 0 .006.514l3.255 3.185a.32.32 0 0 0 .484-.033l6.272-8.048a.365.365 0 0 0-.063-.51z" fill="#92a58c"/></svg>' +
//         '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="15" id="msg-dblcheck-ack" x="2063" y="2076"><path d="M15.01 3.316l-.478-.372a.365.365 0 0 0-.51.063L8.666 9.88a.32.32 0 0 1-.484.032l-.358-.325a.32.32 0 0 0-.484.032l-.378.48a.418.418 0 0 0 .036.54l1.32 1.267a.32.32 0 0 0 .484-.034l6.272-8.048a.366.366 0 0 0-.064-.512zm-4.1 0l-.478-.372a.365.365 0 0 0-.51.063L4.566 9.88a.32.32 0 0 1-.484.032L1.892 7.77a.366.366 0 0 0-.516.005l-.423.433a.364.364 0 0 0 .006.514l3.255 3.185a.32.32 0 0 0 .484-.033l6.272-8.048a.365.365 0 0 0-.063-.51z" fill="#4fc3f7"/></svg>' +
//         '</span>' +
//         '</span>';

//     return element;
// }

// function animateMessage(message) {
//     setTimeout(function () {
//         var tick = message.querySelector('.tick');
//         tick.classList.remove('tick-animation');
//     }, 500);
// }


// function previewImage() {
//     const image = document.querySelector("#image");
//     const imagePreview = document.querySelector("#image-preview");

//     const oFReader = new FileReader();
//     oFReader.readAsDataURL(image.files[0]);

//     oFReader.onload = function (oFREvent) {
//         imagePreview.src = oFREvent.target.result;
//     };
// }