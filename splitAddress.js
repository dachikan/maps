function splitAddress(address) {
    // 郵便番号と住所部分を切り分ける正規表現
    const regex = /^〒?(\d{3}-\d{4})\s*(.*)$/;
    const match = address.match(regex);
    if (match) {
        return {
            postalCode: match[1],
            address: match[2]
        };
    } else {
        return null;
    }
}