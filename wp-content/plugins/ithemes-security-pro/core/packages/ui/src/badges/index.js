import { useSelect } from '@wordpress/data';
import { coreStore, modulesStore } from '@ithemes/security.packages.data';
import { __ } from '@wordpress/i18n';
import { StyledCheck, StyledClose } from './styles';
import { check as checkIcon, close as closeIcon, shield } from '@wordpress/icons';
import { Badge } from '@ithemes/ui';

export function ActiveUpdatesBadge() {
	const { versionActive, versionSettings, installType } = useSelect( ( select ) => ( {
		versionActive: select( modulesStore ).isActive( 'version-management' ),
		versionSettings: select( modulesStore ).getSettings( 'version-management' ),
		installType: select( coreStore ).getInstallType(),
	} ), [] );

	const updateVulnerabilities = versionActive && versionSettings.update_if_vulnerable;
	const isFree = installType === 'free';

	const text = updateVulnerabilities
		? __( 'Real-Time Updates Active', 'it-l10n-ithemes-security-pro' )
		: __( 'Real-Time Updates Inactive', 'it-l10n-ithemes-security-pro' );

	const tooltip = isFree
		? __( 'Upgrade', 'it-l10n-ithemes-security-pro' )
		: __( 'Enable “Auto Update If Fixes Vulnerability” in Version Management', 'it-l10n-ithemes-security-pro' );

	const icon = updateVulnerabilities
		? <StyledCheck icon={ checkIcon } />
		: <StyledClose icon={ closeIcon } style={ { fill: '#8A2424' } } />;

	return (
		<Badge
			text={ text }
			icon={ icon }
			iconColor="#FFFFFF"
			tooltip={ tooltip }
		/>
	);
}

export function VirtualPatchingBadge() {
	const { hasPatchstack, installType } = useSelect( ( select ) => ( {
		hasPatchstack: select( coreStore ).hasPatchstack(),
		installType: select( coreStore ).getInstallType(),
	} ), [] );

	const isFree = installType === 'free';

	const text = hasPatchstack
		? __( 'Virtual Patching Active', 'it-l10n-ithemes-security-pro' )
		: __( 'Virtual Patching Inactive', 'it-l10n-ithemes-security-pro' );

	const tooltip = isFree
		? __( 'Upgrade', 'it-l10n-ithemes-security-pro' )
		: null;

	const icon = hasPatchstack
		? shield
		: <StyledClose icon={ closeIcon } style={ { fill: '#8A2424' } } />;

	return (
		<Badge
			text={ text }
			icon={ icon }
			iconColor="#6817C5"
			tooltip={ tooltip }
		/>
	);
}
