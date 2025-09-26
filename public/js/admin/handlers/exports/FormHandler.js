import SelectorInput from "../../components/Selector.js";

const products = [
    { id: 1, label: "Sản phẩm A" },
    { id: 2, label: "Sản phẩm B" },
    { id: 3, label: "Sản phẩm C" }
];

const selector = new SelectorInput({
    inputEl: document.getElementById("product-search"),
    options: products,
    mode: "multiple", // hoặc "single"
    onSelect: selectedOptions => {
        console.log("Selected options:", selectedOptions);
    }
});

