/**
 * 記事削除に関するAjax処理を管理するクラス
 */
class ArticleManager {
    constructor() {
        // CSRFトークン取得
        this.csrfToken = document.querySelector('meta[name="csrf-token"]')
            .getAttribute('content');
        this.initEvents();
    }

    /**
     * イベントリスナーの登録
     */
    initEvents() {
        // 単体削除ボタン
        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', (e) => this.handleDelete(e));
        });

        // 一括削除ボタン
        const bulkBtn = document.getElementById('bulk-delete-btn');
        if (bulkBtn) {
            bulkBtn.addEventListener('click', () => this.handleBulkDelete());
        }

        // チェックボックスの状態監視（ボタンの活性化）
        document.querySelectorAll('.article-checkbox').forEach(cb => {
            cb.addEventListener('change', () => this.toggleBulkButton());
        });
    }

    /**
     * 単体削除の実行
     * @param {Event} event
     * @returns {Promise<void>}
     */
    async handleDelete(event) {
        if (!confirm('本当にこの記事を削除してもよろしいですか？')) {
            return;
        }

        // 記事ID取得
        const id = event.currentTarget.dataset.id;
        try {
            const response = await this.sendRequest(`/articles/${id}`, 'DELETE');
            if (response.success) {
                // 画面からその記事を消す
                this.removeElement(id);

                // 成功メッセージを出す
                alert(response.message);

                // 最後にボタンの状態を更新する
                this.toggleBulkButton();
            }

            } catch (error) {
            alert('削除に失敗しました。');
        }
    }

    /**
     * 一括削除の実行
     * @returns {Promise<void>}
     */
    async handleBulkDelete() {
        const checkedBoxes = document.querySelectorAll('.article-checkbox:checked');
        const selectedIds = Array.from(checkedBoxes).map(cb => cb.value);

        if (selectedIds.length === 0 || !confirm('選択した記事を削除しますか？')) {
            return;
        }

        try {
            const response = await this.sendRequest(
                '/articles/bulk-delete',
                'POST',
                { ids: selectedIds }
            );

            if (response.success) {
                // 削除前にチェック状態を強制解除
                checkedBoxes.forEach(cb => {
                    cb.checked = false;
                });

                // 画面から要素を消す
                selectedIds.forEach(id => this.removeElement(id));

                alert(response.message);

                // 最後にボタン状態を更新
                this.toggleBulkButton();
            }
        } catch (error) {
            alert('一括削除に失敗しました。');
        }
    }
    
    /**
     * APIリクエストの共通処理
     * @param {string} url
     * @param {string} method
     * @param {Object|null} data
     */
    async sendRequest(url, method, data = null) {
        const options = {
            method: method,
            headers: {
                'X-CSRF-TOKEN': this.csrfToken,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        };
        if (data) options.body = JSON.stringify(data);

        const response = await fetch(url, options);
        return await response.json();
    }

    /**
     * DOMから記事要素を削除
     * @param {string} id
     */
    removeElement(id) {
        const element = document.querySelector(`[data-article-id="${id}"]`);
        if (element) {
            element.style.transition = '0.3s';
            element.style.opacity = '0';
            setTimeout(() => element.remove(), 300);
        }
    }

    /**
     * 一括削除ボタンの活性・非活性を切り替える
     * * @returns {void}
     */
    toggleBulkButton() {
        const bulkButton = document.getElementById('bulk-delete-btn');
        if (!bulkButton) {
            return;
        }

        // 画面上に存在する、チェック済みのボックスを「最新の状態」で取得します
        const checkedBoxes = document.querySelectorAll(
            '.article-checkbox:checked'
        );

        // チェックされている数が0個ならtrue（無効）、1個以上ならfalse（有効）
        bulkButton.disabled = (checkedBoxes.length === 0);
    }
}

// 初期化
document.addEventListener('DOMContentLoaded', () => new ArticleManager());