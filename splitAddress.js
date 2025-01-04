function splitAddress(address) {
    // ͹���ֹ�Ƚ�����ʬ���ڤ�ʬ��������ɽ��
    const regex = /^��?(\d{3}-\d{4})\s*(.*)$/;
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