import Helper from "../../utils/Helper.js";
import FormValidator from "../../shared/FormValidator.js";
import ImportService from "../../services/ImportService.js";
import ProductService from "../../services/ProductService.js";
import SupplierService from "../../services/SupplierService.js";
import SupplierSelector from "../../components/SupplierSelector.js";
import ProductSelector from "../../components/ProductSelector.js";
import TotalCalculator from "../../components/TotalCalculator.js";

export default class FormHandler{

    constructor() {
        this.initValidator();
        this.initProductSelector();
        this.initSupplierSelector();
    }

    initValidator() {
        this.validator = new FormValidator(
            "#import-create-form",
            {
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
            }, 
            (formData, form) => {
                this.onFormSubmit(formData, form);
            }
        );
    }

    async initSupplierSelector() {
        try {
            this.supplierService = new SupplierService();
            const suppliers = await this.supplierService.getSuppliers();
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

    async initProductSelector() {
        try {
            this.productService = new ProductService();
            const products = await this.productService.getProducts();
            
            this.calculator = new TotalCalculator(
                document.getElementById('total-import-amount') // span hoặc div hiển thị tổng
            );

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

    onFormSubmit(data, form) {
        console.log("Submit form data:", data, form);
    }
}

// Khởi tạo khi DOM ready
document.addEventListener("DOMContentLoaded", () => new FormHandler());
