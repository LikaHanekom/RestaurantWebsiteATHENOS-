//document close button functionality
document.querySelector(".close-btn").addEventListener("click", function () {
    if (document.referrer) {
        window.history.back();
    } else {
        window.location.href = "index.html"; // fallback page
    }
});

const locations = {
    joburg: {
        email: "joburg@restaurant.com",
        phone: "011 123 4567",
        time: ["17:00", "18:00", "19:00", "20:00"]
    },
    pretoria: {
        email: "pretoria@restaurant.com",
        phone: "012 987 6543",
        time: ["16:30", "17:30", "18:30", "19:30"]
    }
};

const select = document.getElementById("locationSelect");
const details = document.getElementById("locationDetails");

select.addEventListener("change", function(){
    const selected = this.value;

    //if not selected the change will remain hidden
    if(!selected){
        details.classList.add("hidden");
        return;
    }

    //when a location is selected it will get the details of the location and display.
    const data = locations[selected];

    document.getElementById("email").textContent = data.email;
    document.getElementById("phone").textContent = data.phone;

    const timeContainer = document.getElementById("times");
    timeContainer.innerHTML = "";

    data.time.forEach(time => {
        const section = document.createElement("section");
        section.classList.add("time-slot");
        section.textContent = time;
        timeContainer.appendChild(section);
    });

    details.classList.remove("hidden");

});

