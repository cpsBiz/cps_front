// sub-4
const $sub4 = document.querySelector('.sub-4');

// sub-5
const $sub5 = document.querySelector('.sub-5');
const $sub5ToolTipBoxs = document.querySelectorAll(
  '.sub-5 .point-info .tool-tip-box',
);

// sub-5-1
const $sub5_1 = document.querySelector('.sub-5-1');
const $sub5_1ListWrapBox = document.querySelector('.sub-5-1 .list-wrap-box');
const $sub5_1ListWrapBoxFirstList = document.querySelector(
  '.sub-5-1 .list-wrap-box .first-list',
);
const $sub5_1ListWrapBoxListWrap = document.querySelector(
  '.sub-5-1 .list-wrap-box .list-wrap',
);
const $sub5_1ListWrapBoxListWrapLists = document.querySelectorAll(
  '.sub-5-1 .list-wrap-box .list-wrap .list',
);

// select-wrap > list-wrap-box
const $selectWrapListWrapBox = document.querySelector(
  '#select-wrap .list-wrap-box',
);
const $selectWrapListWrapBoxListWrap = document.querySelector(
  '#select-wrap .list-wrap-box .list-wrap',
);
const $selectWrapListWrapBoxListWrapLists = document.querySelectorAll(
  '#select-wrap .list-wrap-box .list-wrap .list',
);

window.addEventListener('load', () => {
  // $sub-4
  if ($sub4) {
    const sub4FormBoxObj = JSON.parse(
      sessionStorage.getItem('form-box-number'),
    );
    if (sub4FormBoxObj) {
      const $sub4AskElms = document.querySelectorAll(sub4FormBoxObj.askElms);
      const $sub4AskTarget = document.querySelector(sub4FormBoxObj.askTarget);
      const sub4AskText = sub4FormBoxObj.askText;
      const $sub4AskValue = document.querySelector(sub4FormBoxObj.askValue);
      const $sub4FormBoxElms = document.querySelectorAll(
        sub4FormBoxObj.formBoxElms,
      );
      const $sub4FormBoxTarget = document.querySelector(
        sub4FormBoxObj.formBoxTarget,
      );

      $sub4AskElms.forEach((elm) => elm.classList.remove('on'));
      $sub4AskTarget.classList.add('on');
      $sub4AskValue.innerText = sub4AskText;
      $sub4FormBoxElms.forEach((elm) => elm.classList.remove('on'));
      $sub4FormBoxTarget.classList.add('on');
      $sub4AskTarget.querySelector('.ico-check').classList.add('on');
    }
  }

  // sub-5
  if ($sub5) {
    $sub5.addEventListener('click', (e) => {
      if (e.target.closest('.tool-tip')) return;
      if (e.target.tagName.toLowerCase() !== 'button') {
        $sub5ToolTipBoxs.forEach((elm) => elm.classList.remove('on'));
      }
    });

    $sub5ToolTipBoxs.forEach((elm) => {
      elm.addEventListener('click', (e) => {
        if (e.target.closest('.tool-tip')) return;
        if (!elm.classList.contains('on')) {
          $sub5ToolTipBoxs.forEach((elm) => elm.classList.remove('on'));
          elm.classList.add('on');
        } else if (elm.classList.contains('on')) {
          $sub5ToolTipBoxs.forEach((elm) => elm.classList.remove('on'));
        }
      });
    });
  }

  // sub-5-1
  if ($sub5_1) {
    let listHeight = 0;
    let flag = true;
    $sub5_1ListWrapBoxFirstList.addEventListener('click', () => {
      if (!$sub5_1ListWrapBox.classList.contains('on')) {
        if (!flag) return;
        flag = false;
        $sub5_1ListWrapBox.classList.add('on');
        $sub5_1ListWrapBoxListWrapLists.forEach((elm) => {
          listHeight += Number(
            getComputedStyle(elm).height.replace(/[^0-9]/g, ''),
          );
        });
        $sub5_1ListWrapBoxListWrap.style.height = `${listHeight}px`;
        setTimeout(() => {
          $sub5_1ListWrapBoxListWrap.style.height = '100%';
          listHeight = 0;
          flag = true;
        }, 300);
      } else if ($sub5_1ListWrapBox.classList.contains('on')) {
        if (!flag) return;
        $sub5_1ListWrapBox.classList.remove('on');
        $sub5_1ListWrapBoxListWrap.style.height = `${listHeight}px`;
      }
    });
  }

  if ($selectWrapListWrapBox) {
    let listHeight = 0;
    $selectWrapListWrapBox.classList.add('on');
    $selectWrapListWrapBoxListWrapLists.forEach((elm) => {
      listHeight += Number(getComputedStyle(elm).height.replace(/[^0-9]/g, ''));
    });
    $selectWrapListWrapBoxListWrap.style.height = `${listHeight}px`;
    setTimeout(() => {
      $selectWrapListWrapBoxListWrap.style.height = '100%';
      listHeight = 0;
    }, 300);
  }
});

if ($inputFile1) {
  const $fileSizeValue = document.querySelector('.file-info .size');
  const $fileList = document.querySelector('.file-list');
  let fileData = {};
  let fileListIdx = 0;
  let fileTotalSize = 0;
  let fileUnit = 'Byte';
  const maxFiles = 5;

  function updateFileSizeDisplay() {
    if (fileUnit === 'Byte') {
      $fileSizeValue.innerText =
        (fileTotalSize * 1000000).toFixed(0) + fileUnit;
    } else if (fileUnit === 'KB') {
      $fileSizeValue.innerText = (fileTotalSize * 1000).toFixed(1) + fileUnit;
    } else if (fileUnit === 'MB') {
      $fileSizeValue.innerText = fileTotalSize.toFixed(1) + fileUnit;
    }
  }

  function renderFileList() {
    $fileList.innerHTML = '';
    for (let i in fileData) {
      $fileList.innerHTML += `
        <div class="list">
          <p class="name">${fileData[i].name}</p>
          <button type="button" class="ico-close type2" data-idx="${i}">삭제</button>
        </div>
      `;
    }
    const $fileListsRemoveBtn = document.querySelectorAll(
      `.file-list .list > button`,
    );
    $fileListsRemoveBtn.forEach((elm) => {
      elm.addEventListener('click', () => fileListRemove(elm));
    });
  }

  $inputFile1.addEventListener('change', (e) => {
    const currentFileCount = Object.keys(fileData).length;
    const newFileCount = e.target.files.length;
    if (currentFileCount + newFileCount > maxFiles) {
      alert(`최대 ${maxFiles}개의 파일만 첨부할 수 있습니다.`);
      return;
    }

    for (let i = 0; i < $inputFile1.files.length; i++) {
      const file = $inputFile1.files[i];
      const imageType = [
        'image/jpg',
        'image/png',
        'image/gif',
        'application/pdf',
      ];

      if (!imageType.includes(file.type)) {
        alert(
          `파일 첨부는 JPG / PNG / GIF / PDF 만 가능합니다. ${file.name}은/는 ${
            file.type.split('/')[1]
          } 타입이므로 첨부 할 수 없습니다.`,
        );
        continue;
      }

      if (
        Object.keys(fileData).some((key) => fileData[key].name === file.name)
      ) {
        alert(`${file.name}와/과 중복되는 이름의 파일이 첨부되어 있습니다.`);
        continue;
      }

      if (fileTotalSize + file.size * 0.000001 >= 10) {
        alert(
          `파일용량이 10MB를 초과 하였습니다. ${file.name}은/는 첨부할 수 없습니다`,
        );
        continue;
      }

      fileData[fileListIdx] = {
        name: file.name,
        size: file.size,
        type: file.type,
      };

      fileTotalSize += file.size * 0.000001;

      if (fileTotalSize < 1) {
        fileUnit = 'KB';
      } else if (fileTotalSize >= 1) {
        fileUnit = 'MB';
      }

      updateFileSizeDisplay();
      renderFileList();
      fileListIdx += 1;
    }
  });

  function fileListRemove(elm) {
    const idx = elm.dataset.idx;
    fileTotalSize -= fileData[idx].size * 0.000001;

    delete fileData[idx];

    if (Object.keys(fileData).length <= 0) {
      fileTotalSize = 0;
    }

    if (fileTotalSize < 0.001) {
      fileUnit = 'Byte';
    } else if (fileTotalSize < 1) {
      fileUnit = 'KB';
    } else {
      fileUnit = 'MB';
    }

    updateFileSizeDisplay();
    renderFileList();
  }
}
