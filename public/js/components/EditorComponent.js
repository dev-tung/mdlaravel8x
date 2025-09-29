export default class EditorComponent {
    constructor(selector, scriptPath = '/js/libraries/ckeditor.js') {
        this.selector = selector;
        this.scriptPath = scriptPath;
        this.editor = null;
    }

    loadScript() {
        return new Promise((resolve, reject) => {
            if (window.ClassicEditor) return resolve();

            const script = document.createElement('script');
            script.src = this.scriptPath;
            script.onload = () => resolve();
            script.onerror = () => reject(new Error('Không load được CKEditor từ source'));
            document.head.appendChild(script);
        });
    }

    init(content = '') {
        return this.loadScript()
            .then(() => {
                if (typeof ClassicEditor !== 'undefined') {
                    const element = document.querySelector(this.selector);
                    if (!element) {
                        throw new Error(`Không tìm thấy element với selector: ${this.selector}`);
                    }

                    // set content nếu có
                    element.value = content;

                    return ClassicEditor
                        .create(element)
                        .then(editor => {
                            this.editor = editor;

                            // nếu content được truyền thì update vào editor
                            if (content) {
                                editor.setData(content);
                            }

                            return editor;
                        })
                        .catch(error => {
                            console.error('CKEditor init error:', error);
                        });
                }
            })
            .catch(error => console.error('Lỗi load CKEditor:', error));
    }

    getData() {
        return this.editor ? this.editor.getData() : '';
    }

    setData(content) {
        if (this.editor) {
            this.editor.setData(content);
        }
    }

    destroy() {
        if (this.editor) {
            this.editor.destroy()
                .then(() => {
                    this.editor = null;
                })
                .catch(err => console.error('Destroy editor error:', err));
        }
    }
}
