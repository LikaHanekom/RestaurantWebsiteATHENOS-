let voucherMode = "personal";
let selectedDesign = "";

//open the popup
function openPopup(type = "personal") {

    
    voucherMode = type;

    document.getElementById("voucherPopup").style.display = "flex";

    document.getElementById("popupTitle").innerText =
        type === "personal" ? "Personal Gift Voucher" : "Corporate Gift Voucher";

    showStep(1); 
}

//reset Function for popup state
function resetPopupState(){
    selectedDesign = "";

    //remove selected class from all design cards
    document.querySelectorAll(".card").forEach(c => c.classList.remove("selected"));

    //clear all fields
    document.getElementById("amount").value = "";
    document.getElementById("message").value = "";
    document.getElementById("EMAIL").value = "";

    //reset selected design text
    const selectedDesignText = document.getElementById("selectedDesignText");
    if(selectedDesignText){
        selectedDesignText.innerText = "Selected:None";
    }

    //reset to step 1
    document.querySelectorAll(".step").forEach(s => s.classList.remove("active"));
}


//close the popup
function closePopup() {
    document.getElementById("voucherPopup").style.display = "none";
    resetPopupState(); 

    document.getElementById("voucherPopup").addEventListener("click", function(e) {
    if (e.target === this) { // Clicked on the overlay, not the content
        closePopup();
        resetPopupState();
    }
});
}

//switch between steps
function showStep(step) {
    document.querySelectorAll(".step").forEach(s => s.classList.remove("active"));
    document.getElementById("step" + step).classList.add("active");
}

//select a specific design
function selectDesign(card, type) {
    document.querySelectorAll(".card").forEach(c => c.classList.remove("selected"));

    card.classList.add("selected");
    selectedDesign = type;

    document.getElementById("selectedDesignText").innerText =
        "Selected: " + type;

    showStep(2);
}

//Submit the voucher
function submitVoucher() {
    let amount = document.getElementById("amount").value;
    let message = document.getElementById("message").value;
    let email = document.getElementById("email").value;

    if (!selectedDesign) {
        alert("Please select a design first");
        return;
    }

    if (!amount || !email) {
        alert("Please complete required fields");
        return;
    }

    alert(
        `Voucher Sent!\nMode: ${voucherMode}\nDesign: ${selectedDesign}\nAmount: R${amount}`
    );

    closePopup();
}