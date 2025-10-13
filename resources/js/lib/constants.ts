
export enum Genders {
    MALE = 'Male',
    FEMALE = 'Female'
}

// export const accountTypeOptions = ['PayPal', 'CashApp', 'Venmo', 'Zelle', 'Apple Pay', 'Bank Transfer', 'E-Transfer'];
export const countries = ['US', 'UK', 'Canada'];

export enum WalletType {
    PAYPAL = 'PayPal',
    CASHAPP = 'CashApp',
    VENMO = 'Venmo',
    ZELLE = 'Zelle',
    APPLEPAY = 'Apple Pay',
    BANKTRANSFER = 'Bank Transfer',
    ETRANSFER = 'E-Transfer',

}

export const countryOptions = countries.map((country) => ({ label: country, value: country.toLowerCase() }));

export const genderOptions = Object.keys(Genders).map((key) => ({
    label: Genders[key as keyof typeof Genders],
    value: key.toLowerCase()
}));

export const accountTypeOptions = Object.keys(WalletType).map((key) => ({
    label: WalletType[key as keyof typeof WalletType],
    value: key.toLowerCase()
}));



export const walletIconsMap: Partial<Record<WalletType, string>> = {
    [WalletType.PAYPAL.toLowerCase()]: '/assets/images/paypal.png',
    [WalletType.CASHAPP.toLowerCase()]: '/assets/images/cash-app.png',
    [WalletType.APPLEPAY.toLowerCase()]: '/assets/images/apple-pay.png',
}