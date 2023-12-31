/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import { useViewportMatch } from '@wordpress/compose';
import { useDispatch, useSelect } from '@wordpress/data';

/**
 * iThemes dependencies
 */
import { Button, Heading, Text, TextSize, TextVariant } from '@ithemes/ui';
import { HiResIcon } from '@ithemes/security-ui';
import store from '../../store';

/**
 * Internal dependencies
 */
import { SiteScanIssuesSlot, SiteScanMutedIssuesSlot } from '../slot-fill';
import { SiteScanSuccess } from '@ithemes/security-style-guide';
import {
	StyledListHeading,
	StyledTypeHeading,
	StyledNoScans,
	TabHeading,
	StyledTabContainer,
} from './styles';

export default function ScanResultsTab( { hasIssues, type } ) {
	const { isScanRunning } = useSelect( ( select ) => ( {
		isScanRunning: select( store ).isScanRunning(),
	} ), [] );

	const isSmall = useViewportMatch( 'small', '<' );
	const isLarge = useViewportMatch( 'large' );

	return (
		<StyledTabContainer>
			<TabHeading>
				<Heading level={ 3 } size={ TextSize.LARGE } weight={ 600 } text={ __( 'Scan Results', 'it-l10n-ithemes-security-pro' ) } />
			</TabHeading>
			{ isSmall
				? <ResultsList hasIssues={ hasIssues } isScanRunning={ isScanRunning } type={ type } />
				: <ResultsTable hasIssues={ hasIssues } isScanRunning={ isScanRunning } isLarge={ isLarge } type={ type } /> }
		</StyledTabContainer>
	);
}

function ResultsList( { hasIssues, isScanRunning, type } ) {
	return (
		<>
			<StyledListHeading>
				<Text
					textTransform="uppercase"
					variant={ TextVariant.DARK }
					text={ __( 'Type and Scan Info', 'it-l10n-ithemes-security-pro' ) }
				/>
				<Text
					textTransform="uppercase"
					variant={ TextVariant.DARK }
					text={ __( 'Severity', 'it-l10n-ithemes-security-pro' ) }
				/>
			</StyledListHeading>
			{ isScanRunning || hasIssues ? (
				<>
					{ type === 'active' && <SiteScanIssuesSlot /> }
					{ type === 'muted' && <SiteScanMutedIssuesSlot /> }
				</>
			) : (
				<NoResultsEmptyState />
			) }
		</>
	);
}

function ResultsTable( { hasIssues, isScanRunning, isLarge, type } ) {
	return (
		<table className="itsec-scan__table">
			<thead>
				{ isLarge ? (
					<tr>
						<StyledTypeHeading as="th" text={ __( 'Type', 'it-l10n-ithemes-security-pro' ) } />
						<Text as="th" text={ __( 'Scan Info', 'it-l10n-ithemes-security-pro' ) } />
						<Text as="th" text={ __( 'Severity', 'it-l10n-ithemes-security-pro' ) } />
						<Text as="th" text={ __( 'Action', 'it-l10n-ithemes-security-pro' ) } align="right" />
					</tr>
				) : (
					<tr>
						<Text as="th" text={ __( 'Type', 'it-l10n-ithemes-security-pro' ) } />
						<Text as="th" text={ __( 'Scan Info', 'it-l10n-ithemes-security-pro' ) } />
						<Text as="th" text={ __( 'Severity', 'it-l10n-ithemes-security-pro' ) } />
						<Text as="th" text={ __( 'Action', 'it-l10n-ithemes-security-pro' ) } align="right" />
					</tr>
				) }
			</thead>

			{ isScanRunning || hasIssues ? (
				<tbody>
					{ type === 'active' && <SiteScanIssuesSlot /> }
					{ type === 'muted' && <SiteScanMutedIssuesSlot /> }
				</tbody>
			) : (
				<tbody>
					<tr>
						<td colSpan="6">
							<NoResultsEmptyState />
						</td>
					</tr>
				</tbody>
			) }
		</table>
	);
}

function NoResultsEmptyState() {
	const { startScan } = useDispatch( store );
	const { hasRunScan } = useSelect( ( select ) => ( {
		hasRunScan: select( store ).hasCompletedScan(),
	} ), [] );

	const onClick = () => {
		startScan();
	};

	return (
		<StyledNoScans>
			<HiResIcon icon={ <SiteScanSuccess /> } />
			<Text
				variant={ TextVariant.DARK } weight={ 700 }
				text={ hasRunScan
					? __( 'No scan results found!', 'it-l10n-ithemes-security-pro' )
					: __( 'Scan to find issues with your site’s security.', 'it-l10n-ithemes-security-pro' ) }
			/>
			<Button onClick={ onClick } variant="primary" text={ __( 'Start Site Scan', 'it-l10n-ithemes-security-pro' ) } />
		</StyledNoScans>
	);
}

