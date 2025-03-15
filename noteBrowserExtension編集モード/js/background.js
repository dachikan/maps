chrome.runtime.onMessage.addListener((request, sender, sendResponse) => {
  if (request.action === 'getTabInfo') {
    chrome.tabs.query({ active: true, currentWindow: true }, (tabs) => {
      if (tabs && tabs.length > 0) {
        sendResponse({ url: tabs[0].url });
      } else {
        sendResponse({ url: '' });
      }
    });
    return true; // 非同期レスポンスのため true を返す
  }
});