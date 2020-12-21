(() => {
  const editors = document.querySelectorAll('myb-editor');

  for(let editor of editors){
    const ifrEdit = editor.querySelector('iframe.editor-text')
    let ifrDoc = ifrEdit.document;
    if (ifrEdit.contentWindow)ifrDoc = ifrEdit.contentWindow.document;
    const style = document.createElement('style')
    style.textContent = `
      body {
        overflow-y: auto;
        font-size: 16px;
        font-family: 'Arial', Times New Roman, Times, serif, sans-serif;
        line-height: 1.4;
        -webkit-nbsp-mode: space;
        line-break: after-white-space;
        -webkit-user-modify: read-write;
        overflow-wrap: break-word;
        word-wrap: break-word;
        max-width: 100vw;
        min-height: calc(100vh - 60px);
        caret-color: blue;
      }
      body[placeholder]:empty::before {
        content: attr(placeholder);
        color: gray;
        font-style:italic;
      }
      body::after {
        display: block;
        content: '';
        height: 60px;
      }
    `
    ifrDoc.head.appendChild(style)
    const ifrBody = ifrDoc.body;
    ifrBody.contentEditable = true
    ifrBody.setAttribute('placeholder','Olá mundo')
    const textEdit = editor.querySelector('.myb-htmleditor > textarea')

    ifrBody.addEventListener('keypress', function(e){
      textEdit.value = e.target.innerHTML
    });

    const editorButtons = editor.querySelectorAll('editor-tab > button');
    for(let edBtn of editorButtons){
      edBtn.addEventListener('click', function(e){
        e.preventDefault();
        e = e.target;
        let action = e.dataset.action;
        let value = e.dataset.value;
        formatText(action, value);
      });
    }

    const formatText = (cmd, value = null) => {
      ifrDoc.execCommand(cmd, false, value);
      ifrDoc.body.focus();
    }
  }

  const permalink = document.querySelector('.article_url > #url');
  const the_title = document.querySelector('#post_title');

  the_title.addEventListener('keyup', (e) => {
    let title = e.target.value;
    let the_perma = permalink.querySelector('span')
    the_perma.innerText = title
  })

})();