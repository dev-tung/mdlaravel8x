import Helper from "../../utils/Helper.js";
import FormValidator from "../../shared/FormValidator.js";
import ImportService from "../../services/ImportService.js";
import SupplierSelector from "../../components/SupplierSelector.js";
import ProductSelector from "../../components/ProductSelector.js";
import ImportCalculator from "../../components/ImportCalculator.js";
import Handler from "../Handler.js";

export default class ListHandler extends Handler {
    constructor() {
        this.service = new ImportService();
    }

    async init() {
        await this.loadSuppliers();
        await this.loadProducts();
        this.initValidator();
    }

    async loadSuppliers() {
        try {
            const suppliers = await this.service.getSuppliers();
            this.supplierSelector = new SupplierSelector(
                suppliers,
                document.getElementById('supplier-search'),
                document.getElementById('supplier-select'),
                document.getElementById('supplier-id')
            );
        } catch (err) {
            console.error(err);
            alert("Không thể tải dữ liệu nhà cung cấp");
        }
    }

    async loadProducts() {
        try {
            const products = await this.service.getProducts();
            this.productSelector = new ProductSelector(
                products,
                document.getElementById('product-search'),
                document.getElementById('product-select'),
                document.querySelector('#product-selected-table tbody'),
                this.calculator
            );
        } catch (err) {
            console.error(err);
            alert("Không thể tải dữ liệu sản phẩm");
        }
    }

    initValidator() {
        this.initValidator(
            "#import-create-form",
            {
                supplier_id: { 
                    required: true 
                },
                supplier_search: { 
                    required: true 
                },
                import_date: { 
                    required: true 
                },
                status: { 
                    required: true 
                },
                payment_method: { 
                    required: true 
                }
            }
            , (formData) => {
                this.onSubmit(formData)
            }
        );
    }

    onSubmit(data, form) {
        // logic kiểm tra giá và submit
        let hasError = false;
        form.querySelectorAll('input[name^="product_import_price_display["]').forEach(displayInput => {
            const hiddenInput = displayInput.closest('td').querySelector('.price-hidden');
            const val = Number(hiddenInput.value);
            if (!val || val <= 0) {
                hasError = true;
                displayInput.classList.add('is-invalid');
            }
        });

        if (hasError) {
            alert("Có sản phẩm chưa nhập giá hợp lệ, vui lòng kiểm tra lại.");
            return;
        }

        if (confirm("Bạn có chắc chắn muốn lưu phiếu nhập này?")) {
            form.submit();
        }
    }
}

// Khởi tạo khi DOM ready
document.addEventListener("DOMContentLoaded", () => new ImportHandler());
