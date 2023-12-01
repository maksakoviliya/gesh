import { useToast } from 'vue-toast-notification'
import 'vue-toast-notification/dist/theme-default.css'

const $toast = useToast()

export default function () {
	const successToast = (message: string) => {
		let instance = $toast.success(message, {
			position: 'top',
		})
	}
	const errorToast = (message: string) => {
		let instance = $toast.error(message, {
			position: 'top',
		})
	}
	const infoToast = (message: string) => {
		let instance = $toast.info(message, {
			position: 'top',
		})
	}

	return {
		successToast,
		errorToast,
		infoToast,
	}
}
