export const DEFAULT_APP_TITLE = "Zoo Admin"
export default function pageTitle(text) {
    console.log("TEXT", text)
    if (text === undefined || text === null) {
        return DEFAULT_APP_TITLE
    }

    return `${text} | ${DEFAULT_APP_TITLE}`
}