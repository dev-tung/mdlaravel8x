import FormValidator from "../../shared/FormValidator.js";
import ProductService from "../../services/ProductService.js";
import SupplierService from "../../services/SupplierService.js";
import ImportService from "../../services/ImportService.js";
import ImportItemService from "../../services/ImportItemService.js";
import SupplierSelector from "../../components/SupplierSelector.js";
import ProductImportSelector from "../../components/ProductImportSelector.js";
import TotalCalculator from "../../components/TotalCalculator.js";
import PriceValidator from "../../components/PriceValidator.js";

export default class FormHandler {
    constructor() {
        this.initValidator();
        this.initServices();
        this.initSelectors();
        this.initFormMode(); // phân tách create / edit
    }

    // -------------------- Initialize services --------------------
    initServices() {
        this.productService    = new ProductService();
        this.supplierService   = new SupplierService();
        this.importService     = new ImportService();
        this.importItemService = new ImportItemService();
    }

    // -------------------- Form validation --------------------
    initValidator() {
        this.priceValidator = new PriceValidator(
            document.querySelector('#product-selected-table tbody'),
            'product_import_price_display'
        );

        this.validator = new FormValidator(
            "#import-form",
            {
                supplier_search : { required: true },
                import_date     : { required: true },
                status          : { required: true },
                payment_method  : { required: true }
            },
            (formData, form) => {
                if (!this.priceValidator.validate()) return;
                this.onFormSubmit(formData, form);
            }
        );
    }

    // -------------------- Initialize selectors --------------------
    async initSelectors() {
        await this.initSupplierSelector();
        await this.initProductImportSelector();
    }

    async initSupplierSelector() {
        try {
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

    async initProductImportSelector() {
        const products = await this.productService.getProducts();
        this.totalCalculator = new TotalCalculator(
            document.getElementById('total-import-amount')
        );

        const importId = document.getElementById('import-id')?.value;
        let existingProducts = [];

        if (importId) {
            const items = await this.importItemService.getByImportId(importId);
            existingProducts = items.map(i => ({
                id: i.product_id,
                name: i.product.name,
                quantity: i.quantity,
                price: parseFloat(i.import_price),
                is_gift: i.is_gift
            }));
        }

        this.productImportSelector = new ProductImportSelector(
            products,
            document.getElementById('product-search'),
            document.getElementById('product-select'),
            document.querySelector('#product-selected-table tbody'),
            this.totalCalculator,
            this.priceValidator,
            existingProducts  // ← load sẵn bảng cho edit
        );
    }

    // -------------------- Form mode --------------------
    initFormMode() {
        const importId = document.getElementById('import-id')?.value;
        this.isEdit = !!importId; // phân biệt create / edit
    }

    // -------------------- Submit --------------------
    onFormSubmit(formData, form) {
        form.submit();
    }
}

// -------------------- Khởi tạo khi DOM ready --------------------
document.addEventListener("DOMContentLoaded", () => new FormHandler());
