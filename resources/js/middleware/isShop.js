export default function ({ $auth, redirect }) {
    if (
        $auth.strategies.RetaillaravelJWT.$auth.loggedIn &&
        $auth.strategies.RetaillaravelJWT.$auth.state.strategy ===
            "RetaillaravelJWT"
    ) {
        return;
    } else {
        return redirect("/");
    }
}
