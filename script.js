function deleteRecord(id) {
    if (confirm('本当に削除しますか？')) {
        document.getElementById('delete_id').value = id;
        document.getElementById('delete_form').submit();
    }
}
