const selected = document.querySelector(".selected");
const optionsCntainer = document.querySelector(".options-container");

const optionList = document.querySelectorAll(".option");

selected.addEventListener("click", () => {
    optionsCntainer.classList.toggle("active");
});

optionList.forEach(o => {
    o.addEventListener("click", () => {
        selected.innerHTML = o.querySelector("label").innerHTML;
        optionsCntainer.classList.remove("active");
    })
})