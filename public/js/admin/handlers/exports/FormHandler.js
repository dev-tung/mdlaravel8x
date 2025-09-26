import FormValidator from "../../shared/FormValidator.js";
import ProductService from "../../services/ProductService.js";
import CustomerService from "../../services/CustomerService.js";
import ExportService from "../../services/ExportService.js";
import ExportItemService from "../../services/ExportItemService.js";
import CustomerSelector from "../../components/CustomerSelector.js";
import ProductExportSelector from "../../components/ProductExportSelector.js";
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
        this.customerService   = new CustomerService();
        this.exportService     = new ExportService();
        this.exportItemService = new ExportItemService();
    }

    // -------------------- Form validation --------------------
    initValidator() {
        this.priceValidator = new PriceValidator(
            document.querySelector('#product-selected-table tbody'),
            'product_export_discount_display'
        );

        this.validator = new FormValidator(
            "#export-form",
            {
                customer_search : { required: true },
                export_date     : { required: true },
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
        await this.initCustomerSelector();
        await this.initProductExportSelector();
    }

    async initCustomerSelector() {
        try {
            const customers = await this.customerService.getCustomers();
            this.customerSelector = new CustomerSelector(
                customers,
                document.getElementById('customer-search'),
                document.getElementById('customer-select'),
                document.getElementById('customer-id')
            );
        } catch (err) {
            console.error(err);
            alert("Không thể tải dữ liệu nhà cung cấp");
        }
    }

    async initProductExportSelector() {
        const products = await this.productService.getProducts();
        this.totalCalculator = new TotalCalculator(
            document.getElementById('total-export-amount')
        );

        const exportId = document.getElementById('export-id')?.value;
        let existingProducts = [];

        if (exportId) {
            const items = await this.exportItemService.getByExportId(exportId);
            existingProducts = items.map(i => ({
                id: i.product_id,
                name: i.product.name,
                quantity: i.quantity,
                price: parseFloat(i.export_price),
                is_gift: i.is_gift
            }));
        }

        this.productExportSelector = new ProductExportSelector(
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
        const exportId = document.getElementById('export-id')?.value;
        this.isEdit = !!exportId; // phân biệt create / edit
    }

    // -------------------- Submit --------------------
    onFormSubmit(formData, form) {
        form.submit();
    }
}

// -------------------- Khởi tạo khi DOM ready --------------------
document.addEventListener("DOMContentLoaded", () => new FormHandler());
