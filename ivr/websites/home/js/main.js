const spinner = document.getElementById("spinner");
const mainContent = document.getElementById("main-content");

const editor = new EditorJS({
    holder: "editorjs",
    tools: {
        header: Header,
        underline: Underline,
        table: Table,
        marker: Marker,
        list: NestedList,
        image: {
            class: ImageTool,
            config: {
                endpoints: {
                    byFile: "link to backend"
                }
            }
        }
    },
    onReady: () => {
        $(spinner).fadeOut().next($(mainContent).fadeIn());
    },
    onChange: () => {
        editor.save().then((output) => {
            console.log(output);
        }).catch((error) => {
            console.log('Saving failed: ', error);
        });
    }
});