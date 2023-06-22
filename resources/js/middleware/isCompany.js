export default function ({ $auth, redirect }) {
    if (
        $auth.strategies.laravelJWT.$auth.loggedIn &&
        $auth.strategies.laravelJWT.$auth.state.strategy === "laravelJWT"
    ) {
        return;
    } else {
        return redirect("/");
    }
}
