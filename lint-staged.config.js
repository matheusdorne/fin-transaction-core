export default {
    "**/*.php": (filenames) => {
        const relativeFiles = filenames.map((file) =>
            file.replace(process.cwd() + "/", ""),
        );

        return `./vendor/bin/sail bin pint ${relativeFiles.join(" ")}`;
    },
    "**/*.{js,vue,html,css,json}": ["prettier --write"],
};
