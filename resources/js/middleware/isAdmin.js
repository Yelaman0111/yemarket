export default function ({ $auth, redirect }) {
    if (
        $auth.strategies.adminJWT.$auth.loggedIn &&
        $auth.strategies.adminJWT.$auth.state.strategy === "adminJWT"
    ) {
        return;
    } else {
        return redirect("/");
    }
}
